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
Route::group(['middleware'=>['HttpsProtocol']], function () {    

    $auth_middleware = 'auth:'.guardName();
    $as = guardName().'.';

    Route::group(['namespace'=>'Superadmin','middleware'=>$auth_middleware, 'as' => $as], function () {    
        Route::resource('vendor', 'Superadmin\VendorController');    
        Route::post('/update-profile', 'UserController@updateProfile');  
    });

    // Routes for super admin only but can use for admin in future
    // that's why their controller belong to the Common Folder
    Route::group(['namespace'=>'Common','middleware'=>$auth_middleware, 'as' => $as], function () {    


      
        // Route::resource('proposal-beneficiary', 'ProposalBeneficiaryController');
      
        
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


        Route::resource('vertical', 'Common\VerticalController');
        Route::resource('service', 'Common\ServiceController');
        Route::resource('source', 'SourceController');


        Route::get('get-service/{vertical_id}', 'SourceController@getservice');
    
    });

    
    // Routes for admin and superadmin 
    Route::group(['namespace'=>'Common','middleware'=>$auth_middleware, 'as' => $as], function () use($auth_middleware) {
        if(isset($auth_middleware) && ($auth_middleware == 'auth:admin' || $auth_middleware == 'auth:superadmin')){
            Route::get('/dashboard', 'HomeController@index');                    
            Route::get('/get-dashboard-chart1', 'HomeController@getDashboardChart1');                    
            Route::get('/get-dashboard-chart2', 'HomeController@getDashboardChart2');                    
        }
    });

    // Route::get('forgot-password', 'Auth\ForgotPasswordController@forgotPassword');
    // Route::Post('forgot-password', 'Auth\ForgotPasswordController@SendLink');
    // Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@resetPassword');
    // Route::post('reset-password', 'Auth\ForgotPasswordController@changePassword');
});
