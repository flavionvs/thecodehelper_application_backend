<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Earn;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Mail;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {        
        session()->flash('type', $data['type']);
        if($data['type'] == 'user'){
            return Validator::make($data, [
                'first_name' => ['required', 'string', 'max:255'],
                'location' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],            
                'phone' => ['required', 'string', 'max:10', 'unique:users'],            
                'password' => ['required', 'string', 'min:8'],
            ],[
                'first_name.required' => 'Name field is required'
            ]);
        }else{
            return Validator::make($data, [
                'first_name' => ['required', 'string', 'max:255'],
                'user_type' => ['required'],
                'certificate' => ['required', 'string'],
                'location' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],            
                'phone' => ['required', 'string', 'max:10', 'unique:users'],            
                'password' => ['required', 'string', 'min:8'],
            ],[
                'first_name.required' => 'Name field is required'
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {      
        DB::BeginTransaction();
        try{
            if($data['type'] == 'user'){
                $user = new User;
                $user->first_name = $data['first_name'];
                $user->location = $data['location'];
                $user->user_type = 'User';
                $user->phone = $data['phone'];
                $user->email = $data['email'];
                $user->password = Hash::make($data['password']);
                $user->token = generateRandomString();
                $user->save();
                // auth()->login($user);
                $role = Role::withoutGlobalScope('not_superadmin')->find(3);
                $user->assignRole($role);
            }else{
                $user = new User;
                $user->first_name = $data['first_name'];
                $user->location = $data['location'];
                $user->user_type = $data['user_type'];
                $user->certificate = $data['certificate'];
                $user->phone = $data['phone'];
                $user->email = $data['email'];
                $user->password = Hash::make($data['password']);
                $user->token = generateRandomString();
                $user->save();            
                // auth()->guard('admin')->login($user);
                $role = Role::withoutGlobalScope('not_superadmin')->find(2);        
                $user->assignRole($role);                        
            }    
            $link = url('verify-email', $user->token);
            \Mail::send('web.mail.registration', ['link' => $link], function($message) use($user){
                $message->subject('Verify your email.');
                $message->to($user->email);
            });
            DB::commit();
            return back()->with('success', 'Verify link has been sent to your registered email.');
        }catch(\Exception $e){
            DB::rollback();
            return back()->with('error', 'Something went wrong!');
        }  
    }
}
