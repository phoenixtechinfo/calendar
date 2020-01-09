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
// Route::group(['middleware' => 'auth:api'], function(){

    // });

Route::post('login', 'Apis\UsersController@login')->middleware('cors');
Route::post('register-user', 'Apis\UsersController@registerUser')->middleware('cors');
Route::get('get-all-settings', 'Apis\SettingsController@getSettings');


Route::match(['post', 'options'], 'check-email', 'Apis\UsersController@isEmailRegistered')->middleware('cors');

Route::group(['middleware' => ['auth:api']], function() {
    Route::get('get-user-details', 'Apis\UsersController@getUser');
    Route::match(['post', 'options'], 'create-event', 'Apis\EventController@createEvent')->middleware('cors');
	Route::get('get-all-events/{type?}', 'Apis\EventController@getEvents');
	Route::get('get-event-details', 'Apis\EventController@getEventDetails');
	Route::match(['post', 'options'], 'edit-event', 'Apis\EventController@editEvent')->middleware('cors');
	Route::match(['post', 'options'], 'edit-profile', 'Apis\UsersController@editProfile')->middleware('cors');
    Route::get('get-all-colors', 'Apis\UsersController@getColors');
    Route::get('get-all-categories', 'Apis\UsersController@getCategories');
    Route::get('get-all-banners', 'Apis\BannerController@getBanners');

});