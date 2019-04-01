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

Auth::routes();

// Pages
Route::view('/', 'home');

// Catch post-login/register
Route::get('/home', function () {
    return redirect('/app');
});

// Load widget iframes
Route::view('widget/bubble', 'widget-bubble');
Route::view('widget/window', 'widget-window');

// App
Route::get('/app{any}', function () {
    $business = App\Business::find(1);
    $business->settings = $business->settings;
    $user = auth()->user();

    return view('app', compact('business', 'user'));
})->where('any', '.*')->middleware('auth');
