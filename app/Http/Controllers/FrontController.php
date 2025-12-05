<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Lang;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\Service;
use Razorpay\Api\Api;
use App\Models\Message;
use App\Models\Technology;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function index()
    {
//         $lang = [
//             "English",
//             "French",
//             "Spanish",
//             "Hindi",
//             "Mandarin Chinese",
//             "Arabic",
//             "French",
//             "Portuguese",
//             "Russian",
//             "Japanese",
//             "German",
//             "Japanese",
//             "Korean",
//             "Italian",
//             "Vietnamese",
//             "Thai",
//             "Persian (Farsi)",
//             "Malay / Indonesian",
//             "Turkish",
//             "Dutch",
//             "Swedish"
//             ];
//             foreach($lang as $l){
//                 Lang::updateOrCreate(['name'=>$l]);
//             }
// $categories = [
//     "Web Development",
//     "App Development",
//     "Web Development",
//     "Web Development",
//     "App Development",
//     "Frontend Development",
//     "Backend Development",
//     "Full Stack Development",
//     "Mobile App Development",
//     "Android App Development",
//     "iOS App Development",
//     "Flutter Development",
//     "React Native Development",
//     "Next.js Development",
//     "Vue.js Development",
//     "Angular Development",
//     "Node.js Development",
//     "Express.js Development",
//     "Django Development",
//     "Flask Development",
//     "FastAPI Development",
//     "Laravel Development",
//     "Spring Boot Development",
//     ".NET Core Development",
//     "WordPress Development",
//     "Shopify Development",
//     "Magento Development",
//     "E-commerce Development",
//     "API Development",
//     "REST API",
//     "GraphQL",
//     "Database Development",
//     "MySQL",
//     "PostgreSQL",
//     "MongoDB",
//     "Redis",
//     "Firebase",
//     "AWS",
//     "Google Cloud",
//     "Microsoft Azure",
//     "Docker",
//     "Kubernetes",
//     "CI/CD Pipelines",
//     "DevOps Engineering",
//     "Cloud Architecture",
//     "SaaS Development",
//     "Progressive Web App (PWA) Development",
//     "Hybrid App Development",
//     "Automation & Scripting",
//     "Web App Development",
//     "Landing Page Development",
//     "Backend as a Service (BaaS)",
//     "Microservices Architecture"
// ];

// foreach($categories as $c){
//     Technology::updateOrCreate(['name'=>$c]); 
// }

$skills = [
    "PHP",
    "Flutter",
    "React.Js",
    "NodeJs",
    "HTML",
    "Python",
    "Node",
    "Web Development",
    "App Development",
    "Web Development",
    "Web Development",
    "App Development",
    "Frontend Development",
    "Backend Development",
    "Full Stack Development",
    "Mobile App Development",
    "Android App Development",
    "iOS App Development",
    "Flutter Development",
    "React Native Development",
    "Next.js Development",
    "Vue.js Development",
    "Angular Development",
    "Node.js Development",
    "Express.js Development",
    "Django Development",
    "Flask Development",
    "FastAPI Development",
    "Laravel Development",
    "Spring Boot Development",
    ".NET Core Development",
    "WordPress Development",
    "Shopify Development",
    "Magento Development",
    "E-commerce Development",
    "API Development",
    "REST API",
    "GraphQL",
    "Database Development",
    "MySQL",
    "PostgreSQL",
    "MongoDB",
    "Redis",
    "Firebase",
    "AWS",
    "Google Cloud",
    "Microsoft Azure",
    "Docker",
    "Kubernetes",
    "CI/CD Pipelines",
    "DevOps Engineering",
    "Cloud Architecture",
    "SaaS Development",
    "Progressive Web App (PWA) Development",
    "Hybrid App Development",
    "Automation & Scripting",
    "Web App Development",
    "Landing Page Development",
    "Backend as a Service (BaaS)",
    "Microservices Architecture"
];

foreach($skills as $s){
    Category::updateOrCreate(['name'=>$s,'slug'=>strtolower(str_replace(' ', '-', $s))]);
}
        return view('web.index');
    }
    public function login(Request $request)
    {        
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);
        $user = User::whereEmail($request->email)
            ->whereRole('User')
            ->first();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials']);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials']);
        }
        auth()->login($user);
        $navbar = view('web.layout.navbar')->render();
        return response()->json(['status' => true, 'message' => 'Logged in successfully!', 'login' => true, 'navbar' => $navbar]);
    }
 


    public function forgotPassword()
    {
        if (auth()->check()) {
            return redirect('/');
        }
        return view('web.reset-password.forgot-password-form');
    }

    public function resetPassword()
    {
        if (auth()->check()) {
            return back();
        }
        return view('web.reset-password.reset-password-form');
    }

   

    public function userLogin(Request $request){
        $user = User::whereEmail($request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return back()->with('failed', 'Invalid credentials!');
        }
        if($user->verify == '0'){
            return back()->with('failed', 'Email not verified!');
        }
        if($user->user_type == 'User'){
            auth()->login($user);   
            return redirect('/myorder');
        }elseif($user->user_type != 'User'){
            auth()->guard('admin')->login($user);
            return redirect('admin/dashboard');
        }        
    }

    public function SignupPage(){
        if(auth()->guard('admin')->check() && auth()->guard('admin')->user()->user_type != 'User'){
            return redirect('admin/dashboard');                    
        }elseif(authCheck() && authUser()->user_type == 'User'){
            return redirect('/');
        }
        return view('front.authPage.signup');
    }

    public function ResetPasswordPage(){
        return view('front.authPage.resetPassword');
    }
    public function changePasswords(){
        return view('front.authPage.changePassword');
    }
   
    public function verify($token){                        
        $user = User::whereToken($token)->first();
        if(!$user){
            return redirect('/')->with('error', 'Invalid link');
        }
        $user->verify = '1';
        $user->token = '';
        $user->save();
        if($user->user_type == 'User'){
            auth()->login($user);
            return redirect('/myorder')->with('success', 'Your email is verified successfully');
        }else{
            auth()->guard('admin')->login($user);
            return redirect('admin/dashboard')->with('success', 'Your email is verified successfully');
        }                                
    }
    public function changePassword(Request $request){
        request()->validate([
        'otp'=>'required',
        'password'=>'confirmed|min:8'
        ]);
        
        $user = User::where('otp', $request->otp)->first();        
        if($user){
            $user->password = Hash::make($request->password);
            $user->otp = '';
            $user->save();
        }else{
            return back()->with('failed', 'Invalid OTP!');
        }        
        Auth::login($user);
        return redirect('/');
    }

}
