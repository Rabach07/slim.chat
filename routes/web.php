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

// App
Route::view('/app{any}', 'app')->where('any', '.*');
