<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('main');

Route::get('page/{id}','ApiCommonController@index');
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'],function (){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['prefix'=>'user'],function (){
        Route::get('user', 'UserController@index');
        Route::post('list', 'UserController@userlist'); 
        Route::get('user-view/{id}', 'UserController@UserDetails'); 
    });
    
    Route::group(['prefix'=>'content'],function (){
         Route::get('content', 'ContentController@index');
         Route::get('edit-content/{id}', 'ContentController@getContent');
         Route::post('update-content', 'ContentController@updateContent');
     });
     
    Route::group(['prefix'=>'setting'],function (){
        Route::get('setting', 'SettingsController@index');
        Route::post('save-settings', 'SettingsController@saveettings');
    });
});
