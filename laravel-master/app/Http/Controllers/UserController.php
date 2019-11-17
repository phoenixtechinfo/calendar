<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\models\events;
use App\models\Categories;
use Storage;
use Validator;
use Carbon\Carbon;
use File;
use Auth;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns=Schema::getColumnListing('user');
        $orderBy = ($request->input('sortBy') && in_array($request->input('sortBy'), $columns))?$request->input('sortBy'):'id';
        $orderOrder = ($request->input('sortOrder') && ($request->input('sortOrder') == 'asc' || $request->input('sortOrder') == 'desc'))?$request->input('sortOrder'):'asc';
        $limit = env('PAGINATION_PER_PAGE_RECORDS') ? env('PAGINATION_PER_PAGE_RECORDS') : 5;
        $search = ($request->input('search') && $request->input('search') != '')?$request->input('search'):'';
        $users = User::where(function($query) use ($search){
            if($search) {
                $searchColumn = ['firstname', 'lastname', 'email', 'mobilenumber'];
                foreach ($searchColumn as $singleSearchColumn) {
                    $query->orWhere($singleSearchColumn, "LIKE", '%' . $search . '%');
                }
            }
        });
        if(Auth::user()->role == 2) {
            $users = $users->where('role', '!=', 1);
        }
        $users = $users->orderBy($orderBy, $orderOrder)->paginate($limit);
        return view('users/index', compact('users')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::all();
        return view('users/add_user', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'mobilenumber' => 'required|numeric',
            'role' => 'required',
            'category' => 'required',
            'email' => 'required|email|unique:users,email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'password' => 'required|nullable|confirmed|min: 8|max: 16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/ ',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $users = new User();
        $users->firstname = $request->firstname;
        $users->lastname = $request->lastname;
        $users->mobilenumber = $request->mobilenumber;
        $users->role = $request->role;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->created_by = Auth::user()->id;
        $users->modified_by = Auth::user()->id;
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
        $category = Categories::find($request->category);
        $users->categories()->attach($category);
        $request->session()->flash('alert-success', 'User created successfully');
        return redirect()->to('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $categories_names = array();
        foreach($user->categories as $categories) {
            $categories_names[] = $categories->name;
        }
        return view('users/show_user', compact('user', 'categories_names'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $categories = Categories::all();
        $selected_categories = array();
        foreach($user->categories as $category) {
            $selected_categories[] = $category->id;
        }
        return view('users/edit_user', compact('user', 'categories', 'selected_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'mobilenumber' => 'required|numeric',
            'role' => 'required',
            'category' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'password' => 'sometimes|nullable|confirmed|min: 8|max: 16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/ ',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->mobilenumber = $request->mobilenumber;
        $user->role = $request->role;
        $user->email = $request->email;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->modified_by = Auth::user()->id;
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
        $category = Categories::find($request->category);
        $user->categories()->sync($category);
        $request->session()->flash('alert-success', 'User updated successfully');
        return redirect()->to('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();
        $user->categories()->detach();
        $request->session()->flash('alert-success', 'User deleted successfully');
        return redirect()->to('users');
    }

    // function to upload the file at specific location
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}
