<?php

use App\Events\PropertiesUpdated;
use Illuminate\Support\Facades\Storage;

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

// Business properties
Route::get('businesses/{business}/properties', 'BusinessPropertyController@index');

// Business settings
Route::get('businesses/{business}/settings', 'BusinessSettingController@index');
Route::get('businesses/{business}/settings/{setting}', 'BusinessSettingController@show');
Route::post('businesses/{business}/settings/{setting}', 'BusinessSettingController@update');

// Visitors
Route::apiResource('visitors', 'VisitorController');

// Properties
Route::apiResource('properties', 'PropertyController');

// Conversations
Route::apiResource('conversations', 'ConversationController');

// Messages
Route::apiResource('messages', 'MessageController');

// Visitor Actions
Route::get('announce/{uuid?}', function ($uuid = null) {
    $visitor = App\Visitor::get(1, $uuid);

    // Device info
    $agent = new Jenssegers\Agent\Agent();
    App\Property::set($visitor->id, 'device', $agent->device());
    App\Property::set($visitor->id, 'platform', $agent->isDesktop() ? 'desktop' : 'mobile');
    App\Property::set($visitor->id, 'operating_system', $agent->platform().' '.$agent->version($agent->platform()));
    App\Property::set($visitor->id, 'browser', $agent->browser().' '.$agent->version($agent->browser()));
    App\Property::set($visitor->id, 'language', $agent->languages()[0]);

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
            'uuid'       => $visitor->uuid,
            // 'properties' => $visitor->props,
        ],
    ]);
});

// Route::get('import', function () {
//     $file = json_decode(Storage::get('imports/import2.json'), true);

//     foreach ($file as $key => $data) {
//         $visitor = App\Visitor::get(1); // business_id:1

//         App\Property::set($visitor->id, 'email', $key);

//         foreach ($data as $name => $value) {
//             $name = \Illuminate\Support\Str::slug($name);
//             $name = str_replace('-', '_', $name);

//             App\Property::set($visitor->id, $name, $value);

//             echo $name.'<br>';
//         }
//     }
// });
