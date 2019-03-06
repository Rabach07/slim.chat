<?php

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

// User
Route::get('user', 'UserController@show');
Route::post('user', 'UserController@update');

// Business
Route::apiResource('businesses', 'BusinessController');

// Conversations
Route::apiResource('conversations', 'ConversationController');

// Messages
Route::apiResource('messages', 'MessageController');
