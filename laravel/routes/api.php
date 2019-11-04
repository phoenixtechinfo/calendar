<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register','ApiUserController@Register');
Route::post('login','ApiUserController@login');
Route::post('login-fb','ApiUserController@login_fb');
Route::post('forgot-password','ApiUserController@ForgotPassword');
Route::group(['middleware' => 'ApiToken'], function(){
    Route::group(['prefix'=>'user'],function (){
        Route::post('resend-otp','ApiUserController@ResendOtp');
        Route::post('check-otp','ApiUserController@CheckOtp');
        Route::post('reset-password','ApiUserController@ResetPassword');
        Route::post('get-profile','ApiUserController@getProfile');
        Route::post('update-profile','ApiUserController@UpdateProfile');
        Route::post('device-token','ApiUserController@DeviceToken');
        Route::post('support-mail','ApiUserController@supportMail');
        Route::post('change-password','ApiUserController@userPasswordChange');
        Route::post('log-out','ApiUserController@logout');
    });
    
    Route::group(['prefix'=>'location'],function (){
        Route::post('user-list','ApiCommonController@getUserList');
    });
    Route::group(['prefix'=>'message'],function (){
        Route::post('send-message','MessageController@sendMessage');
        Route::post('message-list','MessageController@getMessageList');
    });
});
Route::get('general-settings','ApiCommonController@getsetting');

Route::post('test','ApiCommonController@test');
    