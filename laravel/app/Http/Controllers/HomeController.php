<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['users'] = DB::table('users')->where('role',1)->count();
        return view('home')->with($data);
    }
}
