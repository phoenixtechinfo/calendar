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
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('events', 'EventController');
    Route::resource('users', 'UserController');
    Route::resource('banners', 'BannerController');
    Route::get('events/add-event', 'EventController@addEvent')->name('add-events');
});
