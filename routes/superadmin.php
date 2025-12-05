<?php

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

Route::group(['as' => 'superadmin.'], function () {
    Route::get('login', 'Superadmin\Auth\LoginController@showLoginForm');
    Route::post('login', 'Superadmin\Auth\LoginController@login');
    Route::post('logout', 'Superadmin\Auth\LoginController@logout');
    Route::get('register', 'Superadmin\Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'Superadmin\Auth\RegisterController@register');
});


