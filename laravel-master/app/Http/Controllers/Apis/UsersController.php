<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Categories;
use App\models\Colors;
use Validator;
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
            'mobilenumber' => 'nullable|numeric',
            'email' => 'required|email|unique:users,email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'password' => 'required|nullable|confirmed|min: 8|max: 16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/ ',
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
        $users->mobilenumber = $request->has('mobilenumber') ? $request->mobilenumber : '';
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        if ($request->has('image') && $request->file('image') != '' && $request->file('image') != null) {
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
            $users->profile_image = $filePath;
         }
        $users->save();
        $category = Categories::find(1);
        $users->categories()->attach($category);
        $user = User::find($users->id);
        $user->created_by = $user->id;
        $user->modified_by = $user->id; 
        $user->save();
        $response['code'] = 200;
        $response['token'] =  $user->createToken('MyApp')-> accessToken; 
        $response['message'] = 'Successfully added';
        return response()->json($response);
    }

    //function to get all the colors 
    public function getColors(Request $request) {
        $colors = Colors::where('created_for', '!=' ,'super admin')->get();
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

    public function getUser() {
        $user = Auth::guard('api')->user();
        $response['code'] = 200;
        $response['data'] = $user;
        return response()->json($response, 200); 
    }

    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

}
