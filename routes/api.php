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

// User settings
Route::get('user/settings', 'SettingController@index');
Route::get('user/settings/{setting}', 'SettingController@show');
Route::post('user/settings/{setting}', 'SettingController@update');

// Businesses
Route::apiResource('businesses', 'BusinessController');

// Business Settings
Route::get('businesses/{business}/settings', 'BusinessSettingController@index');
Route::post('businesses/{business}/settings', 'BusinessSettingController@store');
Route::get('businesses/{business}/settings/{setting}', 'BusinessSettingController@show');
Route::post('businesses/{business}/settings/logo', 'BusinessSettingController@updateLogo');
Route::post('businesses/{business}/settings/{setting}', 'BusinessSettingController@update');

// PropertyDefinitions
Route::apiResource('businesses/{business}/properties', 'PropertyDefinitionController');

// Visitors
Route::apiResource('visitors', 'VisitorController');

// Properties
Route::apiResource('properties', 'PropertyController');

// Conversations
Route::apiResource('conversations', 'ConversationController');

// Messages
Route::apiResource('messages', 'MessageController');

// Visitor Announcement
Route::post('announce', 'AnnounceController@announce');
