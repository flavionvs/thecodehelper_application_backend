<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::group(['as' => 'admin.'], function () {        
    Route::get('login', 'Admin\Auth\LoginController@showLoginForm');
    Route::post('login', 'Admin\Auth\LoginController@login');
    Route::post('logout', 'Admin\Auth\LoginController@logout');
    Route::get('register', 'Admin\Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'Admin\Auth\RegisterController@register');
});
Route::get('/link', function () {
    Artisan::call('storage:link');
});

    
