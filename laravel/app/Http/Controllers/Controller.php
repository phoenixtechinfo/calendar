<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
        $notification = DB::table('notification')->pluck('content', 'page_slug');
        config()->set('notification', $notification);
        $settings = DB::table('settings')->pluck('value', 'code_key');
        config()->set('general_setting', $settings);
    }
    
    public function respondJson($status,$msg,$data=array()){ 
        if($data)
            return response()->json(['status' => $status, 'msg' => $msg, 'data' =>$data ]);
        else
            return response()->json(['status' => $status, 'msg' => $msg, 'data' =>new \stdClass() ]);
    }
}
