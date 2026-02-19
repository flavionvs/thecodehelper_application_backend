<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\AddToCart;
use App\Models\Application;
use App\Models\ContactQuery;
use App\Models\FollowUp;
use App\Models\InActiveUser;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Pincode;
use App\Models\Project;
use App\Models\User;
use App\Models\UserAddress;
use App\Scopes\ActiveScope;
// use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\PaymentIntent;

class ApiController extends Controller
{
    /**
     * IMPORTANT NOTE (Jan 2026):
     * - applications table now uses id as PRIMARY KEY (my_row_id removed)
     * - Standard Laravel Eloquent works normally
     */

    private function findApplicationByAnyId($id)
    {
        $id = is_numeric($id) ? (int) $id : 0;
        if ($id <= 0) return null;

        // Standard lookup by id
        return Application::find($id);
    }

    public function dashboard()
    {
        if (authUser()->role == 'Freelancer') {
            $approved_projects = DB::table('applications')
                ->join('users', 'users.id', '=', 'applications.user_id')
                ->where('user_id', authId())
                ->where('applications.status', 'Approved')
                ->get()
                ->count();

            $applied_projects = DB::table('applications')
                ->join('users', 'users.id', '=', 'applications.user_id')
                ->where('user_id', authId())
                ->where('applications.status', 'Pending')
                ->get()
                ->count();

            $message = DB::table('messages')->where('to', authId())->where('is_read', 0)->count();
            $data['freelancer_approved_projects'] = $approved_projects;
            $data['freelancer_applied_projects'] = $applied_projects;
            $data['freelancer_message_count'] = $message;
        } else {
            $approved_projects = DB::table('applications')
                ->join('projects', 'projects.id', 'applications.project_id')
                ->where('projects.user_id', authId())
                ->where('applications.status', 'Approved')
                ->get()
                ->count();

            $in_progress_projects = DB::table('applications')
                ->join('projects', 'projects.id', 'applications.project_id')
                ->where('projects.user_id', authId())
                ->whereIn('applications.status', ['Approved', 'Completion Requested'])
                ->get()
                ->count();

            $completed_projects = DB::table('applications')
                ->join('projects', 'projects.id', 'applications.project_id')
                ->where('projects.user_id', authId())
                ->where('applications.status', 'Completed')
                ->get()
                ->count();

            $projects = DB::table('projects')->where('user_id', authId())->get()->count();
            $message = DB::table('messages')->where('to', authId())->where('is_read', 0)->count();
            $data['client_projects'] = $projects;
            $data['client_project_in_progress'] = $in_progress_projects;
            $data['client_project_completed'] = $completed_projects;
            $data['client_message_count'] = $message;
        }

        $project = Application::join('projects', 'projects.id', 'applications.project_id')
            ->leftJoin('categories', 'categories.id', 'projects.category_id')
            ->select(
                'projects.*',
                'projects.status as project_status',
                'applications.status as application_status',
                'categories.name as category',
                DB::raw('(SELECT COUNT(*) FROM applications WHERE applications.project_id = projects.id) as application')
            )
            ->when(auth()->user()->role == 'Client', function ($q) {
                $q->where('projects.user_id', authId());
            })
            ->when(auth()->user()->role == 'Freelancer', function ($q) {
                $q->where('applications.user_id', authId());
            })
            ->where('applications.status', '!=', 'Cancelled')
            ->orderByDESC('projects.id')
            ->take(5)
            ->get();

        $prjects = [];
        foreach ($project as $item) {
            $array['id'] = $item->id;
            $array['category_id'] = $item->category_id;
            $array['category'] = $item->category;
            $array['title'] = $item->title;
            $array['slug'] = $item->slug;
            $array['description'] = $item->description;
            $array['budget'] = $item->budget;
            $array['tags'] = $item->tags;
            $array['created_at'] = dateFormat($item->created_at);
            $array['status'] = $item->project_status;
            $array['application'] = $item->application ?? 0;
            $prjects[] = $array;
        }

        $notificaiton = Notification::where('user_id', authId())->orderByDESC('id')->get();
        
        // Add read_at column if missing and get unread count
        $this->ensureReadAtColumn();
        $unreadCount = DB::table('notifications')
            ->where('user_id', authId())
            ->whereNull('read_at')
            ->count();
            
        return response()->json([
            'status' => true, 
            'message' => 'Success', 
            'data' => $data, 
            'projects' => $prjects, 
            'notification' => $notificaiton,
            'unread_count' => $unreadCount,
            'stripe_connected' => !empty(authUser()->stripe_account_id),
        ]);
    }

    public function category()
    {
        $category = DB::table('categories')
            ->when(request()->type, function ($q) {
                $q->join('projects', 'projects.category_id', '=', 'categories.id');
            })
            ->groupBy('categories.id')
            ->orderBy('categories.name', 'asc')
            ->where('categories.status', 'Active')
            ->select('categories.id', 'categories.name', 'categories.slug')
            ->get();

        $data = [];
        if ($category) {
            foreach ($category as $item) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'slug' => $item->slug,
                ];
            }
        }

        return response()->json(['status' => true, 'message' => 'Success!', 'data' => $data]);
    }

    public function technology()
    {
        $category = DB::table('technologies')->where('status', 'Active')->orderBy('name', 'asc')->get();
        $data = [];
        if ($category) {
            foreach ($category as $item) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                ];
            }
        }
        return response()->json(['status' => true, 'message' => 'Success!', 'data' => $data]);
    }

    public function langs()
    {
        $langs = DB::table('langs')->where('status', 'Active')->orderBy('name', 'asc')->get();
        $data = [];
        if ($langs) {
            foreach ($langs as $item) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                ];
            }
        }

        return response()->json(['status' => true, 'message' => 'Success!', 'data' => $data]);
    }

    public function programmingLanguage()
    {
        $programming_languages = DB::table('programming_languages')->where('status', 'Active')->get();
        $data = [];
        if ($programming_languages) {
            foreach ($programming_languages as $item) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                ];
            }
        }
        return response()->json(['status' => true, 'message' => 'Success!', 'data' => $data]);
    }

    // ✅ FIXED: filter now returns id + route_id + applied (and keeps old behavior)
    public function filter()
    {
        $category_slug = request()->category != 'All' ? request()->category : null;
        $category_id = null;

        if ($category_slug) {
            $category = DB::table('categories')->where('slug', $category_slug)->first();
            $category_id = $category->id ?? null;
        }

        $price_range = request()->price_range != 'All' ? request()->price_range : null;

        $project = Project::select('projects.*')
            // ✅ Only show projects that are pending (not yet assigned to a freelancer)
            ->where(function($q) {
                $q->where('projects.status', 'pending')
                  ->whereNull('projects.selected_application_id');
            })
            ->when($price_range, function ($q) use ($price_range) {
                $min_price = explode('-', $price_range)[0] ?? null;
                $max_price = explode('-', $price_range)[1] ?? null;
                if ($min_price !== null) $q->where('selling_price', '>=', $min_price);
                if ($max_price !== null) $q->where('selling_price', '<=', $max_price);
            })
            ->when($category_id, function ($q) use ($category_id) {
                $q->where('category_id', $category_id);
            })
            ->when(request()->search, function ($q) {
                $q->where('projects.title', 'like', '%' . request()->search . '%');
            })
            ->when(request()->sort == 'order_by_desc', function ($q) {
                $q->orderBy('id', 'desc');
            })
            ->when(request()->sort == 'order_by_asc', function ($q) {
                $q->orderBy('id', 'asc');
            })
            ->when(request()->sort == 'z_to_a', function ($q) {
                $q->orderBy('name', 'desc');
            })
            ->when(request()->sort == 'a_to_z', function ($q) {
                $q->orderBy('name', 'asc');
            })
            ->orderByDesc('projects.id')
            ->groupBy('projects.id')
            ->paginate(request()->entries ?? 10);

        $page = page($project);

        if (request()->page >= $page['last_page'] + 1) {
            return response()->json(['status' => false]);
        }

        // ✅ Use user_id if frontend sends it, otherwise fallback to auth user
        $viewerId = request()->user_id ?: (auth()->check() ? authId() : null);

        $data = [];
        if ($project) {
            foreach ($project as $item) {

                // ✅ Determine IDs safely
                $routeId = $item->id;

                // ✅ Guarantee non-zero business id (frontend + applications rely on this)
                $businessId = $item->id;

                // ✅ applied check uses business id (applications.project_id expects projects.id)
                $applied = false;
                if ($viewerId && $businessId) {
                    $applied = Application::where('user_id', $viewerId)
                        ->where('project_id', $businessId)
                        ->exists();
                }

                $array = [];
                $array['id'] = $businessId;        // ✅ never 0
                $array['route_id'] = $routeId;     // ✅ always present
                $array['category_id'] = $item->category_id;
                $array['title'] = $item->title;
                $array['slug'] = $item->slug;
                $array['description'] = $item->description;
                $array['budget'] = $item->budget;
                $array['application'] = $item->application && $item->application->count() ?? 0;
                $array['attachment'] = $item->attachment;
                $array['category'] = $item->category->name ?? null;
                $array['created_at'] = timeFormat($item->created_at);
                $array['applied'] = $applied ? true : false;

                $data[] = $array;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Projects fetched successfully!',
            'page' => $page,
            'data' => $data
        ]);
    }

    public function projectDetail($slug)
    {
        $project = Project::where('slug', $slug)->first();
        $data['id'] = $project->id;
        $data['category_id'] = $project->category_id;
        $data['title'] = $project->title;
        $data['description'] = $project->description;
        $data['budget'] = $project->budget;
        $data['application'] = $project->application && $project->application->count() ?? 0;
        $data['attachment'] = $project->attachment;
        $data['category'] = $project->category->name ?? null;
        $data['created_at'] = dateFormat($project->created_at);

        return response()->json(['status' => true, 'message' => 'Projects fetched successfully!', 'data' => $data]);
    }

    public function updateProfile()
    {
        try {
            $validator = Validator::make(request()->all(), [
                'name' => 'required',
                'shop_name' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(array('status' => 'Validator Failed', 'errors' => $validator->getMessageBag()->toArray()));
            }
            $rule['name'] = 'required';
            $rule['phone'] = 'required|digits:10|unique:users,email,' . authId();
            $user = User::find(authId());
            $user->first_name = request()->name;
            $user->shop_name = request()->shop_name;
            if (request()->image) {
                $user->image = fileSave(request()->image, 'upload/images/profile', $user->image);
            }
            $user->save();
            UserAddress::updateOrCreate(
                [
                    'user_id' => authId()
                ],
                [
                    'user_id' => authId(),
                    'shop_name' => request()->shop_name,
                    'name' => request()->name,
                    'email' => request()->email,
                    'phone' => request()->phone,
                    'pincode' => request()->pincode,
                    'address1' => request()->house,
                    'address2' => request()->area,
                    'landmark' => request()->landmark,
                    'country' => request()->country,
                    'city' => request()->city,
                    'district' => request()->district,
                    'state' => request()->state,
                ]
            );
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Profile updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => showError($e)]);
        }
    }

    public function payment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // ✅ Log incoming payload (to prove what frontend sends)
            \Log::info('payment() request payload', [
                'applicationId'   => $request->input('applicationId'),
                'application_id'  => $request->input('application_id'),
                'paymentMethod'   => $request->input('paymentMethod'),
                'all'             => $request->all(),
            ]);

            // ✅ Accept both possible field names
            $rawAppId = $request->input('applicationId') ?? $request->input('application_id');

            // ✅ Validate required fields early
            if ($rawAppId === null || $rawAppId === '' || $rawAppId === 'undefined' || $rawAppId === 'null') {
                \Log::error('Missing application id for payment', ['all' => $request->all()]);
                return response()->json([
                    'status'  => false,
                    'message' => 'Missing application id (applicationId/application_id).'
                ], 422);
            }

            $appId = (int) $rawAppId;
            if ($appId <= 0) {
                \Log::error('Invalid application id for payment (must be > 0)', ['appId' => $rawAppId, 'all' => $request->all()]);
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid application id.'
                ], 422);
            }

            $paymentMethod = $request->input('paymentMethod');
            if (!$paymentMethod) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Missing paymentMethod.'
                ], 422);
            }

            /**
             * ✅ Standard Application lookup by id
             */
            $apps = $this->findApplicationByAnyId($appId);
            if (!$apps) {
                \Log::error('Invalid application id for payment', ['appId' => $appId]);
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid application id.'
                ], 422);
            }

            // ✅ Validate required DB fields
            if (empty($apps->project_id) || (int) $apps->project_id === 0) {
                \Log::error('Application missing project_id', [
                    'application_lookup_id' => $appId,
                    'application_id' => $apps->id ?? null,
                    'project_id'            => $apps->project_id
                ]);
                return response()->json([
                    'status'  => false,
                    'message' => 'Application is missing project_id.'
                ], 422);
            }

            // ✅ Stripe requires integer cents
            $amountCents = (int) round(roundOff($apps->total_amount) * 100);

            if ($amountCents <= 0) {
                \Log::error('Invalid amount calculated for payment', [
                    'application_lookup_id' => $appId,
                    'application_id' => $apps->id ?? null,
                    'total_amount'   => $apps->total_amount,
                    'amount_cents'   => $amountCents,
                ]);
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid amount.'
                ], 422);
            }

            \Log::info('Creating Stripe payment', [
                'application_id' => $apps->id ?? null,
                'project_id'     => $apps->project_id,
                'total_amount'   => $apps->total_amount,
                'amount_cents'   => $amountCents,
            ]);

            /**
             * Store application id in Stripe metadata
             */
            $stableAppId = (int) ($apps->id ?? 0);

            if ($stableAppId <= 0) {
                \Log::error('Application has no valid id', [
                    'application_lookup_id' => $appId,
                    'application_id' => $apps->id ?? null,
                ]);
                return response()->json([
                    'status'  => false,
                    'message' => 'Application identifier is invalid.'
                ], 422);
            }

            $paymentIntent = PaymentIntent::create([
                'amount' => $amountCents,
                'currency' => 'usd',
                'payment_method' => $paymentMethod,
                'confirm' => true,

                'metadata' => [
                    'application_id' => (string) $stableAppId,
                    'project_id'     => (string) $apps->project_id,
                    'user_id'        => (string) auth()->id(),
                ],

                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);

            // ✅ If succeeded right away, finalize DB HERE (no webhook dependency)
            if ($paymentIntent->status === 'succeeded') {
                $intentId = $paymentIntent->id ?? null;
                $amountUsd = number_format(((int)$amountCents / 100), 2, '.', '');

                try {
                    DB::transaction(function () use ($apps, $stableAppId, $intentId, $paymentIntent, $amountUsd) {

                        // Find project by id
                        $project = Project::query()
                            ->where('id', (int)$apps->project_id)
                            ->lockForUpdate()
                            ->first();

                        if (!$project) {
                            \Log::warning('Payment succeeded but project not found for finalization', [
                                'project_lookup_id' => $apps->project_id ?? null,
                                'application_id' => $apps->id ?? null,
                                'intent' => $intentId,
                            ]);
                            return;
                        }

                        // Idempotent payment create/update
                        $existing = Payment::where('paymentIntentId', $intentId)->first();
                        if (!$existing) {
                            Payment::create([
                                'user_id'         => $project->user_id ?? authId(), // payer (client)
                                'application_id'  => (int)$stableAppId,             // stable application id
                                'amount'          => $amountUsd,
                                'paymentIntentId' => $intentId,
                                'paymentStatus'   => $paymentIntent->status ?? 'succeeded',
                                'paymentDetails'  => json_encode($paymentIntent),
                                'stripe_transfer_id' => null,
                            ]);
                        } else {
                            $existing->paymentStatus  = $paymentIntent->status ?? $existing->paymentStatus;
                            $existing->paymentDetails = json_encode($paymentIntent);
                            $existing->save();
                        }

                        // Update application status
                        $appId = (int)($apps->id ?? 0);
                        if ($appId > 0) {
                            Application::where('id', $appId)->update([
                                'status' => 'Approved',
                            ]);
                        }

                        // Update project status/payment
                        $project->payment_status = 'paid';
                        $project->status = 'in_progress';
                        $project->selected_application_id = (int)$stableAppId;
                        $project->save();

                        // ✅ Send notifications to both parties
                        try {
                            // Notify the freelancer that payment received and to start work
                            Notification::create([
                                'user_id' => $apps->user_id, // Freelancer who applied
                                'title' => 'Payment Received – Start Working! 🚀',
                                'message' => "Great news! The client has made the payment for \"{$project->title}\". Please start working on the project now. Once you complete and submit the project, and the client approves the completion, you will be automatically paid.",
                                'type' => 'approved',
                                'link' => '/user/project?type=ongoing',
                                'reference_id' => $project->id,
                            ]);

                            // Notify the client that payment confirmed
                            Notification::create([
                                'user_id' => $project->user_id, // Client who posted the project
                                'title' => 'Payment Confirmed ✅',
                                'message' => "Your payment for \"{$project->title}\" has been confirmed. The freelancer has been notified to start work. You can track progress from your ongoing projects.",
                                'type' => 'payment',
                                'link' => '/user/project?type=ongoing',
                                'reference_id' => $project->id,
                            ]);
                        } catch (\Throwable $notifyError) {
                            \Log::error('Payment notification failed', [
                                'error' => $notifyError->getMessage(),
                                'project_id' => $project->id ?? null,
                            ]);
                        }

                        \Log::info('Payment finalized: project flipped to in_progress + paid', [
                            'intent' => $intentId,
                            'project_id' => $project->id ?? null,
                            'selected_application_id' => $project->selected_application_id ?? null,
                        ]);
                    });
                } catch (\Throwable $e) {
                    \Log::error('Payment succeeded but DB finalization failed', [
                        'intent' => $intentId,
                        'application_id' => $apps->id ?? null,
                        'project_id' => $apps->project_id ?? null,
                        'error' => $e->getMessage(),
                    ]);

                    // Still return success to frontend, but warn (optional)
                    return response()->json([
                        'status' => true,
                        'message' => 'Payment succeeded, but finalization failed (check logs).',
                        'paymentIntent' => $paymentIntent
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Payment succeeded!',
                    'paymentIntent' => $paymentIntent
                ]);
            }

            // ✅ Handle 3DS flows
            if ($paymentIntent->status === 'requires_action') {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret,
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Payment failed or pending.',
                'paymentIntent' => $paymentIntent
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Stripe payment error', [
                'error' => $e->getMessage(),
                'trace' => substr($e->getTraceAsString(), 0, 1500),
            ]);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a Stripe Checkout Session (hosted payment page).
     * Client is redirected to Stripe's page to enter card details.
     * After payment, Stripe redirects back and webhook finalizes.
     */
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $rawAppId = $request->input('applicationId') ?? $request->input('application_id');

            if ($rawAppId === null || $rawAppId === '' || $rawAppId === 'undefined' || $rawAppId === 'null') {
                return response()->json(['status' => false, 'message' => 'Missing application id.'], 422);
            }

            $appId = (int) $rawAppId;
            if ($appId <= 0) {
                return response()->json(['status' => false, 'message' => 'Invalid application id.'], 422);
            }

            $apps = $this->findApplicationByAnyId($appId);
            if (!$apps) {
                return response()->json(['status' => false, 'message' => 'Application not found.'], 422);
            }

            if (empty($apps->project_id) || (int) $apps->project_id === 0) {
                return response()->json(['status' => false, 'message' => 'Application is missing project_id.'], 422);
            }

            // Get project title for the line item description
            $project = Project::find($apps->project_id);
            $projectTitle = $project ? $project->title : 'Project Payment';

            // Amount in cents
            $amountCents = (int) round(roundOff($apps->total_amount) * 100);
            if ($amountCents <= 0) {
                return response()->json(['status' => false, 'message' => 'Invalid amount.'], 422);
            }

            $stableAppId = (int) ($apps->id ?? 0);
            if ($stableAppId <= 0) {
                return response()->json(['status' => false, 'message' => 'Application identifier is invalid.'], 422);
            }

            // Build return URL for embedded checkout
            $frontendUrl = env('FRONTEND_URL', 'https://thecodehelper.com');
            $returnUrl = $frontendUrl . '/payment/success?session_id={CHECKOUT_SESSION_ID}&application_id=' . $stableAppId;

            \Log::info('Creating Stripe Checkout Session (embedded)', [
                'application_id' => $stableAppId,
                'project_id'     => $apps->project_id,
                'total_amount'   => $apps->total_amount,
                'amount_cents'   => $amountCents,
            ]);

            $session = \Stripe\Checkout\Session::create([
                'ui_mode' => 'embedded',
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => $amountCents,
                        'product_data' => [
                            'name' => $projectTitle,
                            'description' => 'Price: $' . number_format($apps->amount, 2) .
                                ' | Code Helper Commission: $' . number_format($apps->admin_amount, 2) .
                                ' (' . $apps->admin_commission . '%)' .
                                ' | Payment Commission: $' . number_format($apps->stripe_amount, 2) .
                                ' (' . $apps->stripe_commission . '%)' .
                                ' | Payment Fee: $' . number_format($apps->stripe_fee, 2),
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'application_id' => (string) $stableAppId,
                    'project_id'     => (string) $apps->project_id,
                    'user_id'        => (string) auth()->id(),
                ],
                'return_url' => $returnUrl,
            ]);

            return response()->json([
                'status' => true,
                'clientSecret' => $session->client_secret,
                'session_id'   => $session->id,
            ]);

        } catch (\Exception $e) {
            \Log::error('Stripe Checkout Session error', [
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function payment_old(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $request->validate([
            'paymentMethod' => 'required|string',
            'amount' => 'required|numeric',
            'applicationId' => 'required|integer',
        ]);

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'payment_method' => $request->paymentMethod,
            ]);

            return response()->json([
                'status' => true,
                'client_secret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function payments()
    {
        $payments = Payment::where('user_id', authId())
            ->orderByDESC('id')
            ->paginate(10);

        $data = [];
        $page = page($payments);

        if ($payments) {
            foreach ($payments as $item) {
                $item->created_at = timeFormat($item->created_at);

                /**
                 * ✅ KEY FIX:
                 * payments.application_id may now store applications.id (stable) for new records
                 * and may store applications.id for old records.
                 */
                $application = $this->findApplicationByAnyId($item->application_id);

                // Avoid broken Eloquent relations (primary key changed); resolve names directly.
                $freelancerName = null;
                $clientName = null;
                $projectTitle = null;

                if ($application) {
                    $freelancer = User::find($application->user_id);
                    $project = Project::find($application->project_id);
                    $client = $project ? User::find($project->user_id) : null;

                    $freelancerName = $freelancer->first_name ?? null;
                    $clientName = $client->first_name ?? null;
                    $projectTitle = $project->title ?? null;
                }

                $data[] = [
                    'id' => $item->id,
                    'amount' => '$' . $item->amount,
                    'paymentStatus' => $item->paymentStatus,
                    'username' => authUser()->role == 'Client' ? $freelancerName : $clientName,
                    'project' => $projectTitle,
                    'paymentIntentId' => $item->paymentIntentId ?? null,
                    'stripe_transfer_id' => $item->stripe_transfer_id ?? null,
                    'created_at' => timeFormat($item->created_at)
                ];
            }
        }

        return response()->json(['status' => true, 'message' => 'Payments fetched successfully!', 'page' => $page, 'data' => $data]);
    }

    public function walletBalance()
    {
        $balance = Payment::whereUserId(authId())->sum('amount');
        return response()->json(['status' => true, 'message' => 'Success', 'balance' => $balance]);
    }

    public function createAccount(Request $request)
    {
        try {
            $user = User::findOrFail(authId());

            Stripe::setApiKey(config('services.stripe.secret'));

            if (!$user->stripe_account_id) {
                $account = Account::create([
                    'type' => 'express',
                    'email' => authUser()->email,
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers' => ['requested' => true],
                    ],
                ]);

                $user->stripe_account_id = $account->id;
                $user->save();
            }

            $returnUrl = config('services.stripe.connect_return_url', 'https://thecodehelper.com/user/account');
            $refreshUrl = config('services.stripe.connect_refresh_url', 'https://thecodehelper.com/user/account');

            $accountLink = AccountLink::create([
                'account' => $user->stripe_account_id,
                'refresh_url' => $refreshUrl,
                'return_url' => $returnUrl,
                'type' => 'account_onboarding',
            ]);

            return response()->json(['status' => true, 'url' => $accountLink->url]);
        } catch (\Exception $e) {
            \Log::error('Stripe createAccount error', ['error' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Failed to create Stripe account: ' . $e->getMessage()], 500);
        }
    }

    public function sendContactQuery(Request $request)
    {
        try {
            $rule['name'] = 'required';
            $rule['phone'] = 'required';
            $rule['email'] = 'required';
            $rule['message'] = 'required';
            $query = new ContactQuery();
            $query->user_id = authId();
            $query->name = request()->name;
            $query->email = request()->email;
            $query->phone = request()->phone;
            $query->message = request()->message;
            $query->save();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Query sent successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Fix inconsistent payment statuses.
     * This endpoint fixes applications/projects that have succeeded payments
     * but incorrect status values.
     * 
     * @param Request $request - accepts 'dry_run' boolean parameter
     * @return \Illuminate\Http\JsonResponse
     */
    public function fixPaymentStatuses(Request $request)
    {
        // Handle schema upgrade for notifications table
        if ($request->boolean('upgrade_notifications_schema', false)) {
            try {
                $columns = DB::select("SHOW COLUMNS FROM notifications");
                $columnNames = array_map(fn($col) => $col->Field, $columns);
                
                $added = [];
                
                if (!in_array('type', $columnNames)) {
                    DB::statement("ALTER TABLE notifications ADD COLUMN `type` VARCHAR(50) NULL AFTER `message`");
                    $added[] = 'type';
                }
                
                if (!in_array('link', $columnNames)) {
                    DB::statement("ALTER TABLE notifications ADD COLUMN `link` VARCHAR(255) NULL AFTER `type`");
                    $added[] = 'link';
                }
                
                if (!in_array('reference_id', $columnNames)) {
                    DB::statement("ALTER TABLE notifications ADD COLUMN `reference_id` BIGINT UNSIGNED NULL AFTER `link`");
                    $added[] = 'reference_id';
                }
                
                return response()->json([
                    'status' => true,
                    'message' => count($added) > 0 
                        ? 'Added columns: ' . implode(', ', $added) 
                        : 'All columns already exist',
                    'columns_added' => $added,
                    'existing_columns' => $columnNames,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Schema upgrade error: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Diagnostic: List tables with id column (INVISIBLE primary key issue)
        if ($request->boolean('diagnose_tables', false)) {
            try {
                $tables = DB::select("SHOW TABLES");
                $dbName = DB::getDatabaseName();
                $tablesWithMyRowId = [];
                
                foreach ($tables as $table) {
                    $tableName = $table->{"Tables_in_{$dbName}"} ?? array_values((array)$table)[0];
                    
                    // Check for id column using SHOW COLUMNS with FULL to see INVISIBLE columns
                    $columns = DB::select("SHOW FULL COLUMNS FROM `{$tableName}`");
                    
                    foreach ($columns as $column) {
                        if ($column->Field === 'id') {
                            // Check if it's the primary key
                            $isPrimary = $column->Key === 'PRI';
                            $isInvisible = strpos($column->Extra ?? '', 'INVISIBLE') !== false 
                                || strpos($column->Extra ?? '', 'invisible') !== false;
                            
                            $tablesWithMyRowId[] = [
                                'table' => $tableName,
                                'is_primary' => $isPrimary,
                                'is_invisible' => $isInvisible,
                                'type' => $column->Type,
                                'extra' => $column->Extra,
                            ];
                            break;
                        }
                    }
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Found ' . count($tablesWithMyRowId) . ' tables with id column',
                    'tables_with_id' => $tablesWithMyRowId,
                    'fix_required' => 'Update Eloquent models to set protected $primaryKey = "id"',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Diagnose error: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Check which tables have id=0 issues (id column not auto-incrementing)
        if ($request->boolean('check_id_issues', false)) {
            try {
                $tablesToCheck = ['users', 'categories', 'technologies', 'langs', 'notifications', 'applications', 'projects', 'payments', 'messages'];
                $results = [];
                
                foreach ($tablesToCheck as $table) {
                    try {
                        // Check if table has id column and if any have id=0
                        $sample = DB::select("SELECT id, id FROM `{$table}` LIMIT 5");
                        $zeroIds = DB::select("SELECT COUNT(*) as cnt FROM `{$table}` WHERE id = 0 OR id IS NULL");
                        $totalCount = DB::select("SELECT COUNT(*) as cnt FROM `{$table}`");
                        
                        $results[$table] = [
                            'sample' => $sample,
                            'zero_id_count' => $zeroIds[0]->cnt ?? 0,
                            'total_count' => $totalCount[0]->cnt ?? 0,
                            'has_id_issue' => ($zeroIds[0]->cnt ?? 0) > 0,
                        ];
                    } catch (\Exception $e) {
                        $results[$table] = ['error' => $e->getMessage()];
                    }
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Tables with id=0 issues need id as primaryKey in Eloquent',
                    'table_analysis' => $results,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Check error: ' . $e->getMessage(),
                ], 500);
            }
        }

        // PERMANENT FIX: Sync id = id for ALL tables
        if ($request->boolean('sync_all_ids', false)) {
            try {
                $tables = ['projects', 'applications', 'payments', 'notifications', 'messages'];
                $results = [];
                
                foreach ($tables as $table) {
                    try {
                        // Update id = id where id is 0 or NULL
                        $updated = DB::update("UPDATE `{$table}` SET id = id WHERE id = 0 OR id IS NULL");
                        $results[$table] = ['fixed' => $updated, 'status' => 'ok'];
                    } catch (\Exception $e) {
                        $results[$table] = ['error' => $e->getMessage()];
                    }
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Synced id = id for all tables',
                    'results' => $results,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sync error: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Debug application count issue
        if ($request->boolean('debug_app_count', false)) {
            try {
                $projectId = $request->input('project_id', null);
                
                if ($projectId) {
                    // Specific project debug
                    $project = DB::select("SELECT id, id, title, user_id FROM projects WHERE id = ? OR id = ? LIMIT 1", [$projectId, $projectId]);
                    $apps = DB::select("SELECT id, id, project_id, status, user_id FROM applications WHERE project_id = ?", [$projectId]);
                    
                    return response()->json([
                        'status' => true,
                        'project' => $project,
                        'applications_for_project' => $apps,
                        'application_count' => count($apps),
                    ]);
                }
                
                $projectsData = DB::select("SELECT id, id, title FROM projects LIMIT 10");
                $applicationsData = DB::select("SELECT id, id, project_id, status FROM applications LIMIT 20");
                
                $countsByProject = [];
                foreach ($projectsData as $p) {
                    $count = DB::select("SELECT COUNT(*) as cnt FROM applications WHERE project_id = ? OR project_id = ?", [$p->id, $p->id]);
                    $countsByProject[] = [
                        'project_id' => $p->id,
                        'project_id' => $p->id,
                        'title' => $p->title,
                        'application_count' => $count[0]->cnt ?? 0,
                    ];
                }
                
                return response()->json([
                    'status' => true,
                    'projects' => $projectsData,
                    'applications' => $applicationsData,
                    'counts_by_project' => $countsByProject,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Debug error: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Fix projects where application is Completed but project status is still in_progress
        if ($request->boolean('fix_completed_projects', false)) {
            try {
                // Find all applications with status "Completed" 
                $completedApps = Application::where('status', 'Completed')->get();
                
                $fixed = [];
                $alreadyOk = [];
                $notFound = [];
                
                foreach ($completedApps as $app) {
                    // Find the project
                    $project = Project::find($app->project_id);
                    
                    if (!$project) {
                        $notFound[] = ['app_id' => $app->id, 'project_id' => $app->project_id];
                        continue;
                    }
                    
                    if ($project->status === 'completed') {
                        $alreadyOk[] = [
                            'project_id' => $project->id,
                            'title' => $project->title,
                        ];
                        continue;
                    }
                    
                    // Update project status to completed
                    $project->status = 'completed';
                    $project->updated_at = now();
                    $project->save();
                    
                    $fixed[] = [
                        'project_id' => $project->id,
                        'title' => $project->title,
                        'old_status' => $project->status,
                        'new_status' => 'completed',
                    ];
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Fixed ' . count($fixed) . ' projects, ' . count($alreadyOk) . ' already correct',
                    'fixed' => $fixed,
                    'already_ok' => $alreadyOk,
                    'not_found' => $notFound,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Fix error: ' . $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ], 500);
            }
        }

        $dryRun = $request->boolean('dry_run', false);
        
        $results = [
            'dry_run' => $dryRun,
            'checked' => 0,
            'already_correct' => 0,
            'fixed' => 0,
            'errors' => 0,
            'details' => [],
        ];

        // Find all succeeded payments
        $payments = Payment::where('paymentStatus', 'succeeded')
            ->whereNotNull('application_id')
            ->where('application_id', '>', 0)
            ->get();

        $results['checked'] = $payments->count();

        foreach ($payments as $payment) {
            $detail = [
                'payment_id' => $payment->id,
                'payment_intent' => $payment->paymentIntentId,
                'changes' => [],
                'status' => 'ok',
            ];

            // Find application by id
            $application = Application::find($payment->application_id);

            if (!$application) {
                $detail['status'] = 'error';
                $detail['error'] = "Application #{$payment->application_id} not found";
                $results['errors']++;
                $results['details'][] = $detail;
                continue;
            }

            $detail['application_id'] = $application->id;

            // Find project
            $projectId = $application->project_id;
            $project = Project::find($projectId);

            if (!$project) {
                $detail['status'] = 'error';
                $detail['error'] = "Project #{$application->project_id} not found";
                $results['errors']++;
                $results['details'][] = $detail;
                continue;
            }

            $detail['project_id'] = $project->id;
            $detail['project_title'] = $project->title;

            $needsFix = false;

            // Check if application needs fixing
            if ($application->status === 'Pending') {
                $needsFix = true;
                $detail['changes'][] = "Application status: Pending → Approved";
            }

            // Check if project payment_status needs fixing
            if ($project->payment_status !== 'paid') {
                $needsFix = true;
                $detail['changes'][] = "Project payment_status: {$project->payment_status} → paid";
            }

            // Check if project status needs fixing
            if ($project->status !== 'in_progress' && $project->status !== 'completed') {
                $needsFix = true;
                $detail['changes'][] = "Project status: {$project->status} → in_progress";
            }

            // Check if selected_application_id is set
            $appPk = $application->id;
            if (!$project->selected_application_id || $project->selected_application_id != $appPk) {
                $needsFix = true;
                $detail['changes'][] = "Project selected_application_id: {$project->selected_application_id} → {$appPk}";
            }

            if (!$needsFix) {
                $results['already_correct']++;
                $results['details'][] = $detail;
                continue;
            }

            $detail['status'] = $dryRun ? 'would_fix' : 'fixed';

            if (!$dryRun) {
                try {
                    // Log the IDs we're using for update
                    \Log::info('[FixPaymentStatuses] About to fix', [
                        'payment_id' => $payment->id,
                        'app_id' => $application->id,
                        'project_id' => $project->id,
                        'appPk' => $appPk,
                    ]);

                    DB::transaction(function () use ($application, $project, $appPk) {
                        // Fix application status
                        if ($application->status === 'Pending') {
                            $affectedApp = DB::table('applications')
                                ->where('id', $application->id)
                                ->update(['status' => 'Approved']);
                            \Log::info('[FixPaymentStatuses] Application update affected rows: ' . $affectedApp);
                        }

                        // Fix project using direct DB query (more reliable with custom primary key)
                        $updateData = [
                            'payment_status' => 'paid',
                            'selected_application_id' => $appPk,
                        ];
                        if ($project->status !== 'completed') {
                            $updateData['status'] = 'in_progress';
                        }
                        
                        // Update by id (the actual primary key)
                        $affectedProj = DB::table('projects')
                            ->where('id', $project->id)
                            ->update($updateData);
                        \Log::info('[FixPaymentStatuses] Project update affected rows: ' . $affectedProj . ' for id: ' . $project->id);
                    });

                    \Log::info('[FixPaymentStatuses] Fixed via API', [
                        'payment_id' => $payment->id,
                        'application_id' => $application->id,
                        'project_id' => $project->id,
                    ]);
                } catch (\Exception $e) {
                    $detail['status'] = 'error';
                    $detail['error'] = $e->getMessage();
                    $results['errors']++;
                    $results['details'][] = $detail;
                    continue;
                }
            }

            $results['fixed']++;
            $results['details'][] = $detail;
        }

        return response()->json([
            'status' => true,
            'message' => $dryRun 
                ? "Dry run complete. {$results['fixed']} records would be fixed." 
                : "Fixed {$results['fixed']} records.",
            'data' => $results,
        ]);
    }

    /**
     * Add type, link, reference_id columns to notifications table if they don't exist
     */
    public function upgradeNotificationsSchema(Request $request)
    {
        try {
            // Check if columns exist
            $columns = DB::select("SHOW COLUMNS FROM notifications");
            $columnNames = array_map(fn($col) => $col->Field, $columns);
            
            $added = [];
            
            if (!in_array('type', $columnNames)) {
                DB::statement("ALTER TABLE notifications ADD COLUMN `type` VARCHAR(50) NULL AFTER `message`");
                $added[] = 'type';
            }
            
            if (!in_array('link', $columnNames)) {
                DB::statement("ALTER TABLE notifications ADD COLUMN `link` VARCHAR(255) NULL AFTER `type`");
                $added[] = 'link';
            }
            
            if (!in_array('reference_id', $columnNames)) {
                DB::statement("ALTER TABLE notifications ADD COLUMN `reference_id` BIGINT UNSIGNED NULL AFTER `link`");
                $added[] = 'reference_id';
            }
            
            return response()->json([
                'status' => true,
                'message' => count($added) > 0 
                    ? 'Added columns: ' . implode(', ', $added) 
                    : 'All columns already exist',
                'columns_added' => $added,
                'existing_columns' => $columnNames,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get notifications for the authenticated user
     */
    public function getNotifications(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Add read_at column if it doesn't exist
        $this->ensureReadAtColumn();

        // Use DB::table to get raw results including id as id
        $notifications = DB::table('notifications')
            ->select([
                'id as id',
                'user_id',
                'title',
                'message',
                'type',
                'link',
                'reference_id',
                'read_at',
                'created_at',
                'updated_at'
            ])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        $unreadCount = DB::table('notifications')
            ->where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'status' => true,
            'message' => 'Notifications retrieved successfully',
            'data' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Get unread notification count
     */
    public function getUnreadNotificationCount(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $this->ensureReadAtColumn();

        $count = DB::table('notifications')
            ->where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'status' => true,
            'count' => $count
        ]);
    }

    /**
     * Ensure read_at column exists in notifications table
     */
    private function ensureReadAtColumn()
    {
        try {
            $columns = DB::select("SHOW COLUMNS FROM notifications LIKE 'read_at'");
            if (empty($columns)) {
                DB::statement("ALTER TABLE notifications ADD COLUMN `read_at` TIMESTAMP NULL DEFAULT NULL AFTER `reference_id`");
            }
        } catch (\Exception $e) {
            \Log::error('Failed to add read_at column: ' . $e->getMessage());
        }
    }

    /**
     * Mark a notification as read
     */
    public function markNotificationRead(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $this->ensureReadAtColumn();

        $updated = DB::table('notifications')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $unreadCount = DB::table('notifications')
            ->where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'status' => true,
            'message' => 'Notification marked as read',
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Mark all notifications as read for the authenticated user
     */
    public function markAllNotificationsRead(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $this->ensureReadAtColumn();

        $updated = DB::table('notifications')
            ->where('user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'status' => true,
            'message' => "Marked {$updated} notifications as read",
            'unread_count' => 0
        ]);
    }

    /**
     * Delete a notification
     */
    public function deleteNotification(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $deleted = DB::table('notifications')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->delete();

        if (!$deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        $unreadCount = DB::table('notifications')
            ->where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'status' => true,
            'message' => 'Notification deleted',
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Delete all notifications for the authenticated user
     */
    public function deleteAllNotifications(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $deleted = Notification::where('user_id', $user->id)->delete();

        return response()->json([
            'status' => true,
            'message' => "Deleted {$deleted} notifications",
            'unread_count' => 0
        ]);
    }
}
