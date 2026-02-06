<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;



Route::group(['middleware' => ['api']], function($router) {
        // ✅ Stripe Webhook (NO auth, NO jwt)
    Route::post('stripe/webhook', 'API\StripeWebhookController@handle');
    Route::get('message', 'API\ApiController@message');
    
    // Temporary migration endpoint - REMOVE AFTER USE
    Route::get('run-migrate-temp-xyz123', function() {
        try {
            \Artisan::call('migrate', ['--force' => true]);
            $output = \Artisan::output();
            return response()->json(['status' => true, 'output' => $output]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    });
    
    // Debug email endpoint - REMOVE AFTER TESTING
    Route::get('test-email-debug', function() {
        $config = [
            'MAIL_MAILER' => env('MAIL_MAILER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD') ? 'SET (hidden)' : 'NOT SET',
            'Send_Grid_API' => env('Send_Grid_API') ? 'SET (hidden)' : 'NOT SET',
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
        ];
        
        try {
            // Create a mock user object for testing
            $mockUser = new \stdClass();
            $mockUser->id = 999;
            $mockUser->first_name = 'Ranjan';
            $mockUser->email = 'ranjans838@gmail.com';
            $mockUser->otp = '123456';
            
            Mail::send('emails.verify-email', [
                'user' => $mockUser,
            ], function ($message) {
                $message->to('ranjans838@gmail.com')
                    ->subject('✉️ Test Email - The Code Helper');
            });
            return response()->json(['status' => true, 'message' => 'Email sent successfully to ranjans838@gmail.com', 'config' => $config]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString(), 'config' => $config]);
        }
    });
    // Removed duplicate: Route::post('send-message') - use the one inside jwt.verify middleware
    Route::post('filter', 'API\ApiController@filter');
    Route::get('category', 'API\ApiController@category');

    Route::get('project/detail/{project_id}', 'API\ApiController@projectDetail');
    Route::group(['middleware' => ['jwt.verify']], function($router) {

        Route::get('dashboard', 'API\ApiController@dashboard');

        Route::post('create-stripe-account', 'API\ApiController@createAccount');


        Route::get('profile/{user_id?}', 'API\ApiUserController@profile');
        Route::post('update-profile', 'API\ApiUserController@updateProfile');
        Route::post('update-professional-profile', 'API\ApiUserController@updateProfessionalProfile');
        Route::get('projects/{id?}', 'API\ApiProjectController@projects');
        Route::get('project/edit/{id}', 'API\ApiProjectController@edit');
        Route::get('ongoing-projects/{id?}', 'API\ApiProjectController@ongoingProjects');
        Route::post('project/create', 'API\ApiProjectController@create');
        Route::get('project/delete/{id}', 'API\ApiProjectController@delete');
        Route::put('project/update/{id}', 'API\ApiProjectController@update');
        Route::post('project/complete/{id}', 'API\ApiProjectController@completed');
        Route::post('project/accept/complete/{id}', 'API\ApiProjectController@acceptCompleted');                        
        
        Route::post('payment', 'API\ApiController@payment');        
        Route::get('wallet-balance', 'API\ApiController@walletBalance');        
        Route::get('account-details', 'API\ApiUserController@accountDetails');        
        
        // Admin/Fix endpoint - requires auth
        Route::post('fix-payment-statuses', 'API\ApiController@fixPaymentStatuses');
        Route::post('upgrade-notifications-schema', 'API\ApiController@upgradeNotificationsSchema');
        
        Route::post('send-contact-query', 'API\ApiController@sendContactQuery');
        
        Route::get('payments', 'API\ApiController@payments');
        Route::get('applications/{project_id}', 'API\ApiProjectController@application');
        Route::post('apply/{project_id_or_slug}', 'API\ApiProjectController@apply');
        Route::get('applied/{project_id}', 'API\ApiProjectController@applied');
        Route::post('update-application-status', 'API\ApiProjectController@updateApplicationStatus');
        Route::post('application/cancel/{application_id}', 'API\ApiProjectController@cancel');
        
        Route::get('delete-account', 'API\ApiUserController@deleteAccount');        
        

        Route::get('get-message/{user_id}', 'API\ApiChatController@getMessage');
        Route::post('send-message', 'API\ApiChatController@sendMessage');
        Route::post('test-send-message', 'API\ApiChatController@testSendMessage');
        Route::post('update-count', 'API\ApiChatController@updateCount');
        Route::get('get-chat-users', 'API\ApiChatController@getChatUsers');

        Route::get('technology', 'API\ApiController@technology');
        Route::get('langs', 'API\ApiController@langs');
        Route::get('programming-language', 'API\ApiController@programmingLanguage');
        Route::get('category/{category_id}', 'API\ApiController@categoryProduct');
        Route::get('product', 'API\ApiController@product');
        Route::get('product/{product_id}', 'API\ApiController@productDetails');
        Route::get('my-cart', 'API\ApiController@myCart');        
        Route::post('add-to-cart', 'API\ApiController@addToCart');        
        Route::get('address', 'API\ApiController@address');        
        Route::post('place-order', 'API\ApiController@placeOrder');        
        Route::get('order', 'API\ApiController@order');        
        Route::post('cancel-order/{order_id}', 'API\ApiController@cancelOrder');        
        Route::post('send-notification', 'API\ApiController@sendNotification');        

        // Notification routes
        Route::get('notifications', 'API\ApiController@getNotifications');
        Route::get('notifications/unread-count', 'API\ApiController@getUnreadNotificationCount');
        Route::post('notifications/{id}/read', 'API\ApiController@markNotificationRead');
        Route::post('notifications/read-all', 'API\ApiController@markAllNotificationsRead');
        Route::delete('notifications/{id}', 'API\ApiController@deleteNotification');
        Route::delete('notifications', 'API\ApiController@deleteAllNotifications');

        Route::get('product/{product_id}', 'API\ApiController@productDetail');
        Route::post('add-to-cart/{product_id}', 'API\ApiController@addToCart');
        Route::get('best-selling-product', 'API\ApiController@bestSellingProduct');
        Route::post('store-pre-initiation', 'API\ApiProposalController@storePreInitiation');
        Route::post('store-post-initiation', 'API\ApiProposalController@storePostInitiation');
        Route::get('proposal-details/{pre_or_post}/{proposal_id}', 'API\ApiProposalController@proposalDetails');
        Route::get('proposal-beneficiaries/{pre_or_post}/{proposal_id}', 'API\ApiProposalController@proposalBeneficiaries');
        Route::post('/user/change-password', 'API\ApiUserController@userChangePassword');
    });
    
    Route::post('/logout', 'API\JWTController@logout');    
    Route::post('/register', 'API\JWTController@register');
    Route::post('/login', 'API\JWTController@login');
    Route::post('/verify-signup-otp', 'API\JWTController@verifySignupOtp');
    Route::post('/resend-signup-otp', 'API\JWTController@resendSignupOtp');
    Route::post('/send-otp', 'API\ApiUserController@sendOtp');
    Route::post('/verify-otp', 'API\ApiUserController@verifyOtp');
    Route::post('/change-password', 'API\ApiUserController@changePassword');
});