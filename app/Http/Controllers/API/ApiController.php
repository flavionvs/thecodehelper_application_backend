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
    public function dashboard(){
        if(authUser()->role == 'Freelancer'){
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
                        // ->select(
                        //     DB::raw("CASE WHEN applications.status = 'Approved' THEN 1 ELSE 0 END as approved_projects"),
                        //     DB::raw("CASE WHEN applications.status = 'Pending' THEN 1 ELSE 0 END as applied_projects")
                        // )
                        // ->first();
            $message = DB::table('messages')->where('to', authId())->where('is_read', 0)->count();
            $data['freelancer_approved_projects'] = $approved_projects;
            $data['freelancer_applied_projects'] = $applied_projects;
            $data['freelancer_message_count'] = $message;
        }else{            
            $approved_projects = DB::table('applications')
                        ->join('projects', 'projects.id', 'applications.project_id')                    
                        ->where('projects.user_id', authId())
                        ->where('applications.status', 'Approved')
                        ->get()
                        ->count();                        
            $in_progress_projects = DB::table('applications')
                        ->join('projects', 'projects.id', 'applications.project_id')                    
                        ->where('projects.user_id', authId())
                        ->whereIn('applications.status', ['Approved','Completion Requested'])
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
         
        $project = Application::join('projects','projects.id','applications.project_id')
                               ->leftJoin('categories','categories.id','projects.category_id')
                                ->select(
                                    'projects.*',
                                    'applications.status as project_status',
                                    'categories.name as category',  
                                    DB::raw('(SELECT COUNT(*) FROM applications WHERE applications.project_id = projects.id) as application')
                                    )
                                ->when(auth()->user()->role == 'Client', function($q){
                                            $q->where('projects.user_id',authId());
                                        })
                                ->when(auth()->user()->role == 'Freelancer', function($q){
                                    $q->where('applications.user_id',authId());
                                })
                                ->where('applications.status','!=','Cancelled')
                                ->orderByDESC('id')
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
        return response()->json(['status' => true, 'message' => 'Success', 'data' => $data, 'projects' => $prjects, 'notification' => $notificaiton]);
    }
    public function category()
    {      
      $category = DB::table('categories')
                        ->when(request()->type, function($q){
                            $q->join('projects', 'projects.category_id', '=', 'categories.id');
                        })
                        ->groupBy('categories.id')
                        ->orderBy('categories.name','asc')
                        ->where('categories.status', 'Active')
                        ->select('categories.id', 'categories.name', 'categories.slug')
                        ->get();
      $data = [];
      if($category){
        foreach($category as $item){
            $data[] = [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
            ];
        }
      }    
      return response()->json(['status'=>true, 'message'=>'Success!', 'data' => $data]);
    }     
    public function technology()
    {      
      $category = DB::table('technologies')->where('status', 'Active')->orderBy('name','asc')->get();
      $data = [];
      if($category){
        foreach($category as $item){
            $data[] = [
                'id' => $item->id,
                'name' => $item->name,
            ];
        }
      }    
      return response()->json(['status'=>true, 'message'=>'Success!', 'data' => $data]);
    }     
    public function langs()
    {      
      $langs = DB::table('langs')->where('status', 'Active')->orderBy('name','asc')->get();
      $data = [];
      if($langs){
        foreach($langs as $item){
            $data[] = [
                'id' => $item->id,
                'name' => $item->name,
            ];
        }
      }    
      return response()->json(['status'=>true, 'message'=>'Success!', 'data' => $data]);
    }     
    public function programmingLanguage()
    {      
      $programming_languages = DB::table('programming_languages')->where('status', 'Active')->get();
      $data = [];
      if($programming_languages){
        foreach($programming_languages as $item){
            $data[] = [
                'id' => $item->id,
                'name' => $item->name,
            ];
        }
      }    
      return response()->json(['status'=>true, 'message'=>'Success!', 'data' => $data]);
    }     

    public function filter(){
      // dd(Cache::get('req'));
      // Cache::forget('req');
      // Cache::put('req', request()->all());
      $category_slug = request()->category != 'All' ? request()->category : null;
    //   return $category_slug;
      $category_id = null;
      if($category_slug){
        $category = DB::table('categories')->where('slug', $category_slug)->first();
        $category_id = $category->id ?? null;
      }
      $price_range = request()->price_range != 'All' ? request()->price_range : null;            
      $project = Project::select('projects.*')
                        ->when($price_range, function($q) use($price_range){                                                        
                          $min_price = explode('-',$price_range)[0] ?? null;
                          $max_price = explode('-',$price_range)[1] ?? null;  
                               $q->where('selling_price', '>=', $min_price);                            
                              $q->where('selling_price', '<=', $max_price);                            
                        })
                    
                        ->when($category_id, function($q) use($category_id){                              
                              $q->where('category_id', $category_id);                            
                        })                                           
                        ->when(request()->search, function($q){                              
                              $q->where('projects.title', 'like','%'.request()->search.'%');                            
                        })                                                                                                                                                  
                        ->when(request()->sort == 'order_by_desc', function($q){                            
                              $q->orderBy('id', 'desc');                            
                        })
                        ->when(request()->sort == 'order_by_asc', function($q){                            
                              $q->orderBy('id', 'asc');                            
                        })
                        ->when(request()->sort == 'z_to_a', function($q){                            
                              $q->orderBy('name', 'desc');                            
                        })
                        ->when(request()->sort == 'a_to_z', function($q){                            
                              $q->orderBy('name', 'asc');                            
                        })
                        ->orderByDESC('projects.id')
                        ->groupBy('projects.id')
                        ->paginate(request()->entries ?? 10);                                                    
      $page = page($project);   
      if(request()->page >= $page['last_page']+1){
          return response()->json(['status' => false]);
      }            
      $data = [];
        $page = page($project);
        if ($project) {
            foreach ($project as $item) {          
                     
                $applied = Application::where('user_id', request()->user_id)->where('project_id',$item->id)->first();
                $array['id'] = $item->id;
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
        return response()->json(['status' => true, 'message' => 'Projects fetched successfully!', 'page' => $page, 'data' => $data]);
    }

    public function projectDetail($slug){        
        $project = Project::where('slug',$slug)->first();                
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

    public function updateProfile(){
      try{
        $validator = Validator::make(request()->all(), [            
          'name' => 'required',
          'shop_name' => 'required',          
        ]);      
        if ($validator->fails()) {            
          return response()->json(array('status'=>'Validator Failed', 'errors' => $validator->getMessageBag()->toArray()));
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
            ],[
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
         ]);             
        DB::commit();
        return response()->json(['status' => true, 'message' => 'Profile updated successfully']);        
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => false, 'message' => showError($e)]);            
        }
    }
  

    public function payment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret')); // Your platform's secret key
    
        try {
            $apps = Application::find($request->applicationId);
            $paymentIntent = PaymentIntent::create([
                'amount' => roundOff($apps->total_amount) * 100, // $1.00 in cents
                'currency' => 'usd',
                'payment_method' => $request->paymentMethod,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);            
            if ($paymentIntent->status === 'succeeded') {                
                    return response()->json(['status' => true, 'message' => 'Payment succeeded!', 'paymentIntent' => $paymentIntent]);                
            } elseif ($paymentIntent->status === 'requires_action') {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret,
                ]);
            } else {
                return response()->json(['error' => 'Payment failed or pending']);
            }
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function payment_old(Request $request)
    {                 
        Stripe::setApiKey(config('services.stripe.secret'));

        // Validate input (optional but recommended)
        $request->validate([
            'paymentMethod' => 'required|string',
            'amount' => 'required|numeric',
            'applicationId' => 'required|integer',
        ]);

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // Convert to cents
                'currency' => 'usd',
                'payment_method' => $request->paymentMethod,
                // 'confirmation_method' => 'manual',
                // 'confirm' => false,
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
                $application = Application::find($item->application_id);
                $data[] = [
                    'id' => $item->id,
                    'amount' => '$'.$item->amount,
                    'paymentStatus' => $item->paymentStatus,
                    'username' => authUser()->role == 'Client' ? ($application->user->first_name ?? null) : ($application->project->user->first_name ?? null),                    
                    'project' => $application->project->title ?? null,
                    'paymentIntentId' => $item->paymentIntentId ?? null,
                    'stripe_transfer_id' => $item->stripe_transfer_id ?? null,
                    'created_at' => timeFormat($item->created_at)
                ];
            }
        }
        return response()->json(['status' => true, 'message' => 'Payments fetched successfully!', 'page' => $page, 'data' => $data]);
    }

    public function walletBalance(){
        $balance = Payment::whereUserId(authId())->sum('amount');        
        return response()->json(['status' => true, 'message' => 'Success', 'balance' => $balance]);
    }

    public function createAccount(Request $request)
    {
        

        $user = User::findOrFail(authId());

        Stripe::setApiKey(config('services.stripe.secret'));

        // If the user already has a Stripe account, use it
        if (!$user->stripe_account_id) {
            // 1. Create Stripe Express account
            $account = Account::create([
                'type' => 'express',
                'email' => authUser()->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);

            // Save the Stripe account ID
            $user->stripe_account_id = $account->id;
            $user->save();
        }

        // 2. Create Stripe onboarding link
        $accountLink = AccountLink::create([
            'account' => $user->stripe_account_id,
            'refresh_url' => 'https://ndpelectronics.com/codehelper/web/user/account',
            'return_url' => 'https://ndpelectronics.com/codehelper/web/user/account',
            'type' => 'account_onboarding',
        ]);

        return response()->json(['status' => true, 'url' => $accountLink->url]);
    }

    public function sendContactQuery(Request $request)
    {
        try{          
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
        return response()->json(['status'=>true, 'message'=>'Query sent successfully.']);
      }catch(\Exception $e){
        DB::rollback();
        return response()->json(['status' => false, 'message' => $e->getMessage()]);
      }           
    }
}