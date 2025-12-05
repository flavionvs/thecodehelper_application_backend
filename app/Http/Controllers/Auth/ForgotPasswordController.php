<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use Hash;
class ForgotPasswordController extends Controller
{
    public function forgotPassword(){   
        return view('auth.superadmin.forgot-password');
    }
    
    public function SendLink(Request $request){
        $token = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);
        $link = url('superadmin/reset-password/'.$token);
        $user = User::where('email', $request->email)->first();
        if(!empty($user)){
        $user->forgot_token = $token;
        $user->save();
        }else{
            return back()->with('failed', 'Email does not match our records!');
        }
        \Mail::send('emails.forgot-password', ['link' => $link],
        function ($message) use ($user)
        {
            $message->to($user->email)->subject('Reset Password Link');              
        });
        return back()->with('success', 'Email sent successfully!');
    }
    
    public function resetPassword(){
        if(auth()->check()){
            return back();
        }
        return view('auth.superadmin.reset-password');
    }
    
    public function changePassword(Request $request){
        request()->validate([
        'password'=>'required|confirmed|min:8'
        ]);
        $user = User::where('forgot_token', $request->forgot_token)->first();
        if(!empty($user)){
            $user->password = Hash::make($request->password);
            $user->forgot_token = '';
            $user->save();
        }else{
            return back()->with('failed', 'Token has expired!');
        }        
        auth()->guard(guardName())->login($user);
        return redirect('superadmin');
    }

}
