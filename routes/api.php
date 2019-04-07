<?php

use App\Events\PropertiesUpdated;
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

// Visitor Actions
Route::post('announce', function (Request $request) {
    $business = App\Business::findByAppId($request->app_id);
    abort_if(! $business, 404, 'Business not found.');

    $visitor = App\Visitor::get($business->id, $request->visitor_uuid);

    // Device info
    $agent = new Jenssegers\Agent\Agent();
    App\Property::set($visitor->id, 'device', $agent->device());
    App\Property::set($visitor->id, 'platform', $agent->isDesktop() ? 'desktop' : 'mobile');
    App\Property::set($visitor->id, 'operating_system', $agent->platform().' '.$agent->version($agent->platform()));
    App\Property::set($visitor->id, 'browser', $agent->browser().' '.$agent->version($agent->browser()));
    App\Property::set($visitor->id, 'language', count($agent->languages()) ? $agent->languages()[0] : '');

    // Geo info
    $ip = request()->ip();
    $geo = json_decode(file_get_contents('https://get.geojs.io/v1/ip/geo/'.$ip.'.json'));
    App\Property::set($visitor->id, 'country', isset($geo->country) ? $geo->country : '');
    App\Property::set($visitor->id, 'region', isset($geo->region) ? $geo->region : '');
    App\Property::set($visitor->id, 'city', isset($geo->city) ? $geo->city : '');
    App\Property::set($visitor->id, 'ip', isset($geo->ip) ? $geo->ip : '');
    App\Property::set($visitor->id, 'timezone', isset($geo->timezone) ? $geo->timezone : '');

    event(new PropertiesUpdated($visitor));

    return response()->json([
        'data' => [
            'uuid'     => $visitor->uuid,
            'business' => [
                'name' => $business->name,
            ],
            'settings' => [
                'color_primary'  => optional(App\Setting::get($business->id, 'color_primary'))->value,
                'color_contrast' => optional(App\Setting::get($business->id, 'color_contrast'))->value,
            ],
        ],
    ]);
});
