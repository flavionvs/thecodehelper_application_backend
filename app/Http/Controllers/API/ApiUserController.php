<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserLang;
use App\Models\UserTechnology;
use App\Models\UserLanguage;
use App\Models\UserProgrammingLanguage;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class ApiUserController extends Controller
{

    public function profile($user_id = null)
    {      
        if($user_id){
          $user = User::find($user_id);
        }else{
          $user = auth()->user();       
        }
        $data = $user;
        $data['image'] = img($user->image);        
        $data['name'] = $user->first_name;        
        $data['phone'] = $user->phone;                                       
        $language = '';
        $programming_language = '';
        $category = '';
        if($user->userLang->count() > 0){
          foreach($user->userLang as $key => $item){
            if(isset($item->lang->name) && $item->lang->name){
              if($key == 0){
                  $language = $item->lang->name;
                }else{
                  $language .= ', '.$item->lang->name;                 
              }
            }
          }
        }

        if($user->userProgrammingLanguage->count() > 0){
          foreach($user->userProgrammingLanguage as $key => $item){
            if(isset($item->language->name) && $item->language->name){
              if($key == 0){
                  $programming_language = $item->language->name;
                }else{
                  $programming_language .= ', '.$item->language->name;                 
              }
            }
          }
        }
        if($user->userTechnology->count() > 0){
          foreach($user->userTechnology as $key => $item){
            if(isset($item->technology->name) && $item->technology->name){
              if($key == 0){
                  $category = $item->technology->name;
                }else{
                  $category .= ', '.$item->technology->name;                 
              }
            }
          }
        }
        $data['category'] = $category;
        $data['programming_language'] = $programming_language;

        $data['language'] = $language;
        
        // if($user->profile_status == 'Private'){
          $data['email'] = '##@####.com';
          $data['phone'] = '### ### ####';          
          $data['linkedin_link'] = '### ### ####';          
          $data['portfolio_link'] = '### ### ####';          
          $data['relevant_link'] = '### ### ####';          
        // }
        return response()->json(['status'=>true, 'message'=>'Profile fetched successfully!', 'data' => $data]);
    }
    public function updateProfile(Request $request)
    {
        try{          
        $rule['name'] = 'required';
        $rule['phone'] = 'required|max:15|unique:users,phone,' . authId();
        $rule['email'] = 'required|unique:users,email,' . authId();
        $rule['country'] = 'required';        
        if(request()->password){
          $rule['password'] = 'min:8';
        }
        $validator = Validator::make($request->all(), $rule);      
        if($validator->fails()){            
          return response()->json(['status' => false, 'message' => 'Validation error', 'data' => validationError($validator)]);
        }
        $user = User::find(authId());
        if(request()->image){
          $user->image = fileSave(request()->image, 'upload/user', $user->image);
        }
        $user->first_name = request()->name;
        $user->email = request()->email;                   
        $user->phone = request()->phone;                   
        $user->country = request()->country;         
        if(!empty(request()->password)){
          $user->password = Hash::make(request()->password);                       
        }                  
        $user->save();           
        DB::commit();    
        $data = [
          'id' => $user->id,
          'role' => $user->role,
          'name' => $user->first_name,
          'phone' => $user->phone,
          'email' => $user->email,
          'country' => $user->country,
          'image' => img($user->image),
      ];    
        return response()->json(['status'=>true, 'message'=>'Profile updated successfully!', 'data' => $data]);
      }catch(\Exception $e){
        DB::rollback();
        return response()->json(['status' => false, 'message' => $e->getMessage()]);
      }           
    }
    public function updateProfessionalProfile(Request $request)
    {      

        Cache::put('req', request()->all());
      
        try{          
        $rule['professional_title'] = 'required';
        $rule['experience'] = 'required';
        $rule['lang_id'] = 'required';
        $rule['about'] = 'required';
        // $rule['description'] = 'required';
        $rule['technology_id'] = 'required';
        $rule['programming_language_id'] = 'required';
        $rule['availability'] = 'required|in:Available,Not Available';
        // $rule['linkedin_link'] = 'required';
        // $rule['portfolio_link'] = 'required';
        // $rule['relevant_link'] = 'required';                
        $validator = Validator::make($request->all(), $rule);      
        if($validator->fails()){            
          return response()->json(['status' => false, 'message' => 'Validation error', 'data' => validationError($validator)]);
        }        
        $req = request()->except('technology_id','programming_language_id','lang_id');
        User::find(authId())->update($req);                
        $user = User::find(authId());        
        if (is_array(request()->lang_id)) {  // [1,2,3]
          UserLang::where('user_id', authId())
              ->whereNotIn('lang_id', request()->lang_id)
              ->delete();  
          
          foreach (request()->lang_id as $item) {
              UserLang::updateOrCreate(
                  ['user_id' => authId(), 'lang_id' => $item],  // Search condition
                  ['user_id' => authId(), 'lang_id' => $item]   // Data to insert/update
              );
          }
        } else {
            UserLang::where('user_id', authId())->delete();
        }
        if (is_array(request()->technology_id)) {  // [1,2,3]
          UserTechnology::where('user_id', authId())
              ->whereNotIn('technology_id', request()->technology_id)
              ->delete();  
          
          foreach (request()->technology_id as $item) {
              UserTechnology::updateOrCreate(
                  ['user_id' => authId(), 'technology_id' => $item],  // Search condition
                  ['user_id' => authId(), 'technology_id' => $item]   // Data to insert/update
              );
          }
        } else {
            UserTechnology::where('user_id', authId())->delete();
        }
        if (is_array(request()->programming_language_id)) {  // [1,2,3]
          UserProgrammingLanguage::where('user_id', authId())
              ->whereNotIn('programming_language_id', request()->programming_language_id)
              ->delete();  
          
          foreach (request()->programming_language_id as $item) {
              UserProgrammingLanguage::updateOrCreate(
                  ['user_id' => authId(), 'programming_language_id' => $item],  // Search condition
                  ['user_id' => authId(), 'programming_language_id' => $item]   // Data to insert/update
              );
          }
        } else {
            UserProgrammingLanguage::where('user_id', authId())->delete();
        }
        if (is_array(request()->language)) {  // [1,2,3]
          UserLanguage::where('user_id', authId())
              ->whereNotIn('language', request()->language)
              ->delete();  
          
          foreach (request()->language as $item) {
              UserLanguage::updateOrCreate(
                  ['user_id' => authId(), 'language' => $item],  // Search condition
                  ['user_id' => authId(), 'language' => $item]   // Data to insert/update
              );
          }
        } else {
            UserLanguage::where('user_id', authId())->delete();
        }
        DB::commit();    
        $data = [          
          'id' => $user->id,
          'professional_title' => $user->professional_title,
          'experience' => $user->experience,
          'language' => $user->language,
          'timezone' => $user->timezone,
          'about' => $user->about,          
          'availability' => $user->availability,
          'profile_status' => $user->profile_status,
          'linkedin_link' => $user->linkedin_link,
          'portfolio_link' => $user->portfolio_link,
          'relevant_link' => $user->relevant_link,
          'technology_id' => $user->userTechnology->pluck('technology_id')->toArray(),
          'lang_id' => $user->userLang->pluck('lang_id')->toArray(),
          'programming_language_id' => $user->userProgrammingLanguage->pluck('programming_language_id')->toArray(),
          'language' => $user->userLanguage->pluck('language')->toArray(),
      ];    
        return response()->json(['status'=>true, 'message'=>'Professional profile updated successfully!', 'data' => $data]);
      }catch(\Exception $e){
        DB::rollback();
        return response()->json(['status' => false, 'message' => $e->getMessage()]);
      }           
    }
    
   public function sendOtp(Request $request){
      $validator = Validator::make($request->all(), [            
        'email' => 'required',
      ]);      
      if ($validator->fails()) {            
        return response()->json(array('status'=>'Validator Failed', 'errors' => $validator->getMessageBag()->toArray()));
      }   
      $user = User::whereEmail($request->email)->first();      
      if(!$user){
        return response()->json(['status' => false, 'message' => 'User does not exist!']);
      }
      $user->otp = rand(100000, 999999);
      $user->otp_sent_time = date('Y-m-d h:i:s');
      $user->save();
      if(!$user){
        return response()->json(['status' => false, 'message' => 'User does not exist!']);
      }
      try{
        EmailService::sendForgotPassword($user);
      }catch(\Exception $e){
        return response()->json(['status' => false, 'message' => 'Otp not sent! use this opt for now '.$user->otp]);
      }
      return response()->json(['status' => true, 'message' => 'Otp has been sent! this will be valid till next 10 minutes.']);
   }    
   public function verifyOtp(Request $request){
    $validator = Validator::make($request->all(), [
      'otp' => 'required',      
    ]);
    $user = User::whereOtp($request->otp)->first();
    if(!$user){
      return response()->json(['status'=>false, 'message'=>'Invalid otp!']);
    }
    if((strtotime(date('Y-m-d h:i:s')) - strtotime($user->otp_sent_time)) > 600){
      return response()->json(['status'=>false, 'message'=>'Otp expired!']);
    }
    $user->otp = '';
    $user->save();
    return response()->json(['status'=>true, 'message'=>'Otp verified!']);
   }
   public function changePassword(Request $request){
    $validator = Validator::make($request->all(), [      
      'otp' => 'required|digits:6',
      'password' => 'required|min:8',
      'confirm_password' => 'required|min:8',
    ]);
    if($request->password != $request->confirm_password){
      return response()->json(['status'=>false, 'message'=>'Password confirmation does`nt match!']);
    }
    if($validator->fails()) {
        return response()->json(['status'=>false, 'message'=>'Validation error', 'data' => validationError($validator)]);
    }
    $user = User::where('otp',$request->otp)->first();
    if(!$user){
      return response()->json(['status'=>false, 'message'=>'Invalid otp sent!']);
    }
      
    if(!$user->otp){
      return response()->json(['status'=>false, 'message'=>'Invalid otp sent!']);
    }

    $user->password = Hash::make($request->password);
    $user->otp = '';
    $user->otp_sent_time = '';
    $user->save();
    return response()->json(['status'=>true, 'message'=>'Password change successfully!']);
  }
   public function UserChangePassword(Request $request){
    $validator = Validator::make($request->all(), [
      'password' => 'required',
      'confirm_password' => 'required'        
    ]);
    if($request->password != $request->confirm_password){
      return response()->json(['status'=>false, 'message'=>'Password confirmation does`nt match!']);
    }
    if($validator->fails()) {
        return response()->json(['status'=>false, 'message'=>'Validation error', 'data' => validationError($validator)]);
    }
    $user = auth()->guard(guardName())->user();
    $user->password = Hash::make($request->password);
    $user->save();
    return response()->json(['status'=>true, 'message'=>'Password updated successfully!']);
  }

  public function accountDetails(){    
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    if(authUser()->stripe_account_id){
      $account = \Stripe\Account::retrieve(authUser()->stripe_account_id);
    }else{
      $account = null;
    }
    $balance = \Stripe\Balance::retrieve();
    $available_balance = 0;
    $pending_balance = 0;
    foreach ($balance->available as $availableBalance) {
        $available_balance = $availableBalance->amount . ' ' . $availableBalance->currency . PHP_EOL;
    }
    foreach ($balance->pending as $pendingBalance) {
        $pending_balance = $pendingBalance->amount . ' ' . $pendingBalance->currency . PHP_EOL;
    }
    return response()->json(['status' => true, 'message' => 'success', 'data' => $account, 'available_balance' => $available_balance, 'pending_balance' => $pending_balance]);        
  }
}