<?php

namespace App\Http\Controllers\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    const DRIVER_TYPE = 'facebook';

    public function handleFacebookRedirect(){
        return Socialite::driver(static::DRIVER_TYPE)->redirect();
    }

    public function handleFacebookCallback(){
            $user = Socialite::driver(static::DRIVER_TYPE)->user();
            $userExisted = User::where('oauth_id', $user->id)->where('oauth_type', DRIVER_TYPE)->first();
            if(!$userExisted){                
                $create = new User;
                $create->name = $user->name;
                $create->email = $user->email;
                $create->oauth_id = $user->id;
                $create->oauth_type = DRIVER_TYPE;
                $create->save();                
            }   
            auth()->login($userExisted);
            return redirect('/');     
    }
}
