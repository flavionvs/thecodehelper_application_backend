<?php

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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


    Route::get('/run', function () {
        // Artisan::call('schedule:run');        
        Artisan::call('migrate');        
        return 'Command Run';
    });
    // Route::get('/link', function () {
    //     Artisan::call('storage:link');
    //     Artisan::call('cache:clear');
    //     Artisan::call('config:clear');    
    //     return 'Storage Linked';
    // });
    Route::group(['middleware'=>['HttpsProtocol']], function () {    
        Auth::routes();    
        Route::get('/', 'FrontController@index')->name('home');
        Route::get('/login', 'FrontController@login')->name('home');        
        
        Route::get('/apply', 'CartController@apply');        

    });