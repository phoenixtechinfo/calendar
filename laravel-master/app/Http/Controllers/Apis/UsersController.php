<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Categories;
use App\models\Colors;
use Validator;
use Storage;
use File;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    //Function to login the data
    public function login(Request $request){ 
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $response['code'] = 401;
            $response['message'] = $validator->errors();    
            return response()->json($response);
        }
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $response['code'] = 200;
            $response['token'] =  $user->createToken('MyApp')->accessToken; 
            $response['data'] = $user;
            return response()->json(['success' => $response]); 
        } 
        else{
            $response['code'] = 401;
            $response['message'] = 'Email or password is incorrect';
            return response()->json(['error'=>$response]); 
        } 
    }

    //Function to sign up a new user
    public function registerUser(Request $request) {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/ ',
        ],[]
        );

        if ($validator->fails()) {
            $response['code'] = 401;
            $response['message'] = $validator->errors();    
            return response()->json($response);
        }
        $users = new User();
        $users->firstname = $request->firstname;
        $users->lastname = $request->lastname;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();
        $users->created_by = $users->id;
        $users->modified_by = $users->id; 
        $users->save();
        $response['code'] = 200;
        $response['token'] =  $users->createToken('MyApp')-> accessToken; 
        $response['message'] = 'Successfully added';
        $response['data'] = $users;
        return response()->json($response);
    }

    //function to get all the colors 
    public function getColors(Request $request) {
        $colors = Colors::where('created_for', '!=' ,'admin')->get();
        $response['code'] = 200;
        $response['data'] =  $colors; 
        return response()->json($response);
    }

    //function to get all the categories
    public function getCategories(Request $request) {
        $categories = Categories::all();
        $response['code'] = 200;
        $response['data'] =  $categories; 
        return response()->json($response);
    }

    //function to get the user details
    public function getUser() {
        $user = Auth::guard('api')->user();
        $categories = $user->categories;
        $response['code'] = 200;
        $response['data'] = $user;
        $response['categories'] = $categories;
        return response()->json($response, 200); 
    }

    //function to update the profile
    public function editProfile(Request $request) {
        $user_data = Auth::guard('api')->user();
        $user = User::find($user_data->id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->mobilenumber = $request->contact_no;
        $user->email = $request->email;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->modified_by = $user->id;
        if ($request->has('image') && $request->file('image') != '' && $request->file('image') != null) {
            if($user->profile_image != '' && $user->profile_image != null){
                $file_name = explode('/', $user->profile_image)[3];
                Storage::delete('public/uploads/user_images/' . $file_name);
            }
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->get('firstname'), '-') . '_' . time();
            $folder = '/uploads/user_images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $user->profile_image = $filePath;
        }
        $user->save();
        // $category = Categories::find(array_map('intval', explode(',', $request->category)));
        // $user->categories()->sync($category);
        $response['code'] = 200;
        $response['message'] = 'Successfully edited';
        return response()->json($response);
    }

    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

    //Function to check the email is already registered or not 
    public function isEmailRegistered(Request $request) {
        if($request->get('id') == null) {
            $user = User::where('email','=', $request->get('email'))->get()->count();
        } else {
            $user = User::where('email','=', $request->get('email'))->where('id', '!=', $request->get('id'))->get()->count();
        }
        if($user >= 1) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

}
