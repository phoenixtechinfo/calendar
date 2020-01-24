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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::group(['middleware' => ['auth:1,2']], function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('events', 'EventController');
    Route::resource('banners', 'BannerController');
    Route::resource('settings', 'SettingController');
    Route::resource('colors', 'ColorController');
    Route::resource('category', 'CategoryController');
    Route::resource('interested-users', 'InterestedUserController');
    Route::get('events/add-event', 'EventController@addEvent')->name('add-events');
});

Route::group(['middleware' => ['auth:1']], function() {
    Route::resource('users', 'UserController');
});
