<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['HttpsProtocol']], function () {

    $auth_middleware = 'auth:' . guardName();
    $as = guardName() . '.';

    /**
     * Superadmin Routes
     * Folder exists: app/Http/Controllers/Superadmin/VendorController.php
     */
    Route::group([
        'namespace'  => 'Superadmin',
        'middleware' => $auth_middleware,
        'as'         => $as
    ], function () {

        // VendorController lives under app/Http/Controllers/Superadmin/VendorController.php
        Route::resource('vendor', 'VendorController');

        // Explicit full namespace to Common\UserController
        Route::post('/update-profile', '\App\Http\Controllers\Common\UserController@updateProfile');
    });

    /**
     * Common Routes
     * Folder exists: app/Http/Controllers/Common/*
     */
    Route::group([
        'namespace'  => 'Common',
        'middleware' => $auth_middleware,
        'as'         => $as
    ], function () {

        Route::get('my-profile', 'HomeController@myProfile');
        Route::post('update-profile', 'HomeController@updateProfile');

        Route::post('update-setting', 'HomeController@updateSetting');
        Route::any('upload-files', 'HomeController@uploadFiles');
        Route::post('remove-file', 'HomeController@removeFile');

        Route::resource('category', 'CategoryController');
        Route::resource('sub-category', 'SubCategoryController');

        Route::post('update-website-setting', 'WebsiteSettingController@updateWebsiteSetting');

        Route::resource('user', 'UserController');
        Route::get('freelancer', 'UserController@freelancer');
        Route::get('client', 'UserController@client');

        Route::resource('project', 'ProjectController');
        Route::get('application/{project_id?}', 'ProjectController@application');

        Route::resource('technology', 'TechnologyController');
        Route::resource('language', 'LanguageController');
        Route::resource('lang', 'LangController');

        Route::get('payment-history', 'HomeController@paymentHistory');

        Route::resource('role', 'RoleAndPermission\RoleController');
        Route::resource('permission', 'RoleAndPermission\PermissionController');
        Route::get('get-permissions/{role_id}', 'RoleAndPermission\PermissionController@getPermissions');
        Route::post('assign-role', 'RoleAndPermission\PermissionController@assignRole');

        Route::resource('vertical', 'VerticalController');
        Route::resource('service', 'ServiceController');

        /**
         * FIX (CRITICAL):
         * Removed routes referencing missing Common\SourceController.
         * If you later add SourceController, re-add the routes.
         */
    });

    /**
     * Dashboard Routes for admin/superadmin
     */
    Route::group([
        'namespace'  => 'Common',
        'middleware' => $auth_middleware,
        'as'         => $as
    ], function () use ($auth_middleware) {

        if (isset($auth_middleware) && ($auth_middleware == 'auth:admin' || $auth_middleware == 'auth:superadmin')) {
            Route::get('/dashboard', 'HomeController@index');
            Route::get('/get-dashboard-chart1', 'HomeController@getDashboardChart1');
            Route::get('/get-dashboard-chart2', 'HomeController@getDashboardChart2');
        }
    });
});

