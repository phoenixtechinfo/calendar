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

Route::match(['post', 'options'], 'create-event', 'Apis\EventController@createEvent')->middleware('cors');
Route::get('get-all-events', 'Apis\EventController@getEvents')->middleware('cors');
Route::get('get-event-details', 'Apis\EventController@getEventDetails')->middleware('cors');
Route::match(['post', 'options'], 'edit-event', 'Apis\EventController@editEvent')->middleware('cors');