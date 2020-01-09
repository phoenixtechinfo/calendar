<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Settings;
use Validator;
use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    //function to get all the settings
    public function getSettings(Request $request) {
        $settingsAll = Settings::all();
        $settings = array();
        foreach ($settingsAll as $setting){
            $settings[$setting['key']] = $setting['value'];
        }
        $response['code'] = 200;
        $response['data'] =  $settings;
        $response['dataAll'] =  $settingsAll;
        $response['defaultBanner'] =  'images/banner.jpg';
        return response()->json($response);
    }

}
