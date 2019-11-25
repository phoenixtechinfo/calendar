<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Banners;
use Validator;
use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BannerController extends Controller
{
    //function to get all the banner
    public function getBanners(Request $request) {
        $banners = Banners::all();
        $response['code'] = 200;
        $response['data'] =  $banners;
        $response['defaultBanner'] =  'images/banner.jpg';
        return response()->json($response);
    }

}
