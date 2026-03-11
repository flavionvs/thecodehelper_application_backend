<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;



Route::group(['middleware' => ['api']], function($router) {
        // ✅ Stripe Webhook (NO auth, NO jwt)
    Route::post('stripe/webhook', 'API\StripeWebhookController@handle');
    Route::get('message', 'API\ApiController@message');

    // ✅ Blog public routes (no auth)
    Route::get('blog', 'API\ApiBlogController@index');
    Route::get('blog/categories', 'API\ApiBlogController@categories');
    Route::get('blog/sitemap', 'API\ApiBlogController@sitemap');
    Route::get('blog/{slug}', 'API\ApiBlogController@show');

    Route::post('filter', 'API\ApiController@filter');
    Route::get('category', 'API\ApiController@category');

    Route::get('project/detail/{project_id}', 'API\ApiController@projectDetail');
    // ✅ Blog management routes (API key auth)
    Route::group(['middleware' => ['blog.apikey']], function () {
        Route::post('blog', 'API\ApiBlogController@store');
        Route::put('blog/{id}', 'API\ApiBlogController@update');
        Route::delete('blog/{id}', 'API\ApiBlogController@destroy');
    });

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
        Route::post('create-checkout-session', 'API\ApiController@createCheckoutSession');        
        Route::post('verify-checkout-session', 'API\ApiController@verifyCheckoutSession');
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

// ── Temporary test-email route (remove after testing) ──
Route::get('test-email/{template}', function ($template) {
    $secret = request()->query('key');
    if ($secret !== 'tch_email_test_2026') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    $to = request()->query('to', 'ranjans838@gmail.com');

    $templates = [
        'verify-email' => [
            'subject' => '✉️ Verify Your Email - The Code Helper',
            'data' => [
                'user' => (object) ['first_name' => 'Ranjan', 'email' => 'ranjans838@gmail.com', 'otp' => '482916'],
            ],
        ],
        'welcome' => [
            'subject' => '👋 Welcome to The Code Helper!',
            'data' => [
                'user' => (object) ['first_name' => 'Ranjan', 'email' => 'ranjans838@gmail.com'],
            ],
        ],
        'project-created' => [
            'subject' => '🚀 Project Created Successfully - The Code Helper',
            'data' => [
                'client_name' => 'Ranjan', 'client_email' => 'ranjans838@gmail.com',
                'project_title' => 'E-Commerce Website Redesign', 'project_id' => 101,
                'project_description' => 'A full redesign of the existing e-commerce platform with modern UI/UX, responsive design, and improved checkout flow.',
                'project_budget' => '2500.00', 'project_slug' => 'e-commerce-website-redesign',
            ],
        ],
        'application-approved' => [
            'subject' => '🚀 Payment Received – Start Working on Your Project - The Code Helper',
            'data' => [
                'freelancer_name' => 'Ranjan', 'freelancer_email' => 'ranjans838@gmail.com',
                'project_title' => 'E-Commerce Website Redesign', 'project_id' => 101,
                'project_description' => 'A full redesign of the existing e-commerce platform with modern UI/UX.',
                'client_name' => 'John Smith', 'client_email' => 'john@example.com', 'budget' => '2500.00',
            ],
        ],
        'payment-successful' => [
            'subject' => '✅ Payment Confirmed - The Code Helper',
            'data' => [
                'client_name' => 'Ranjan', 'client_email' => 'ranjans838@gmail.com',
                'project_title' => 'E-Commerce Website Redesign', 'project_id' => 101,
                'project_description' => 'A full redesign of the existing e-commerce platform.',
                'freelancer_name' => 'Jane Doe', 'freelancer_email' => 'jane@example.com', 'amount' => '2500.00',
            ],
        ],
        'new-application' => [
            'subject' => '📬 New Application Received - The Code Helper',
            'data' => [
                'client_name' => 'Ranjan', 'client_email' => 'ranjans838@gmail.com',
                'project_title' => 'E-Commerce Website Redesign', 'project_id' => 101,
                'project_description' => 'A full redesign of the existing e-commerce platform.',
                'freelancer_name' => 'Jane Doe', 'freelancer_email' => 'jane@example.com', 'amount' => '2000.00',
            ],
        ],
        'completion-requested' => [
            'subject' => '📋 Project Completion Requested - The Code Helper',
            'data' => [
                'client_name' => 'Ranjan', 'client_email' => 'ranjans838@gmail.com',
                'project_title' => 'E-Commerce Website Redesign', 'project_id' => 101,
                'freelancer_name' => 'Jane Doe', 'freelancer_email' => 'jane@example.com',
            ],
        ],
        'project-completed' => [
            'subject' => '🏆 Project Completed - The Code Helper',
            'data' => [
                'user_name' => 'Ranjan', 'user_email' => 'ranjans838@gmail.com',
                'project_title' => 'E-Commerce Website Redesign', 'project_id' => 101,
                'amount' => '2500.00',
                'message' => 'The project has been marked as completed. Great work! Thank you for using The Code Helper.',
            ],
        ],
        'cancellation-approved-refund' => [
            'subject' => '💰 Cancellation Approved – Refund Processed - The Code Helper',
            'view' => 'cancellation-approved',
            'data' => [
                'user_name' => 'Ranjan', 'project_title' => 'E-Commerce Website Redesign', 'project_id' => 101,
                'type' => 'refund', 'amount' => 2025.00,
                'email_message' => 'Your cancellation request for "E-Commerce Website Redesign" has been approved. A refund of $2,025.00 has been processed to your original payment method (after deducting cancellation and processing fees).',
            ],
        ],
        'cancellation-approved-transfer' => [
            'subject' => '✅ Cancellation Approved – Payment Transferred - The Code Helper',
            'view' => 'cancellation-approved',
            'data' => [
                'user_name' => 'Ranjan', 'project_title' => 'E-Commerce Website Redesign', 'project_id' => 101,
                'type' => 'transfer', 'amount' => 1875.00,
                'email_message' => 'The project "E-Commerce Website Redesign" has been cancelled, but your payment of $1,875.00 has been transferred for the work completed.',
            ],
        ],
    ];

    if (!isset($templates[$template])) {
        return response()->json(['error' => 'Unknown template', 'available' => array_keys($templates)], 400);
    }

    $cfg = $templates[$template];
    $view = 'emails.' . ($cfg['view'] ?? $template);
    $subject = '[TEST] ' . $cfg['subject'];

    try {
        Mail::send($view, $cfg['data'], function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
        return response()->json(['status' => true, 'message' => "Email '{$template}' sent to {$to}"]);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
});