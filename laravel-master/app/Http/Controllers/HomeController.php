<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\models\events;
use App\models\Banners;
use App\models\Categories;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = events::with(['user', 'color'])->get();
        $total_count = [];
        $total_count['total_users'] = Auth::user()->role == 1 ? User::all()->count() : User::where('role', '!=', 1)->count();
        $total_count['total_events'] = Auth::user()->role == 1 ? events::all()->count() : events::whereHas('user', function($query)  {
            $query->where('role', '!=', 1);
        })->count();
        $total_count['total_category'] = Categories::all()->count();
        $total_count['total_banners'] = Auth::user()->role == 1 ? Banners::all()->count() : Banners::whereHas('user', function($query)  {
            $query->where('role', '!=', 1);
        })->count();
        return view('home', compact('events', 'total_count'));
    }
}
