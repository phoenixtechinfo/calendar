<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\User;
use Validator;
use Storage;
use File;
use Helper;

class UserController extends Controller
{
    //Function to show all users data
    public function index(Request $request) {
        // $users = User::all();
        return view('users/index');
    }
}
