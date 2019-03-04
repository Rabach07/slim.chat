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

// Route::middleware('auth:api')->get('user', function (Request $request) {
//     return $request->user();
// });

// User
Route::get('user', 'UserController@show');
Route::post('user', 'UserController@update');

// Business
Route::get('business', 'BusinessController@show');
Route::post('business', 'BusinessController@update');

// Messages
Route::apiResource('messages', MessageController::class);
