<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class SettingsController extends Controller
{
    public function index(){  
        $setting = DB::table('settings')->pluck('value','code_key');
        $data['title'] = 'General Settings';
        $data['distance_location'] = $setting['distance_location'];
        $data['user_search_location'] = $setting['user_search_location'];
        $data['support_email'] = $setting['support_email'];
        return view('general_setting')->with($data);
    }
    
    public function saveettings(Request $r){
         DB::beginTransaction();
        $r->validate([
            'distance_location' => 'required|numeric',
            'user_search_location' => 'required|numeric'
        ]);        
        foreach (Input::get() as $key => $value) {            
           $isexit = DB::table('settings')->where('code_key',$key)->value('id');
            if($key != '_token' && $isexit){
                $settings = [
                    'code_key' => $key,
                    'value' => $value,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $data = DB::table('settings')->where('id',$isexit)->update($settings);
            }elseif($key != '_token'){
                $settings = [
                    'code_key' => $key,
                    'value' => $value
                ];
                $data = DB::table('settings')->insert($settings);
            }
        }
        if($data){
            DB::commit();
            Session::flash('message', 'Setting are updated successfully.');
            return redirect('setting/setting');
        }else{
            Session::flash('message', 'Something wrong happen. Please try again!');
            return redirect('setting/setting');
        }
    }
}