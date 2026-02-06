<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnverifiedUser;
use App\Services\EmailService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verifySignupOtp', 'resendSignupOtp']]);
    }

    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(), [
                    'email' => 'required|email|unique:users,email,except',
                    'name' => 'required',
                    'role' => 'required|in:Freelancer,Client',
                    'phone' => 'required',
                    'country' => 'required',
                    'password' => 'required',
                    'term_and_condition' => 'required',
                ]
            );
            if($validator->fails()){
                return response()->json(['status' => false, 'message' => 'Validation error', 'data' => validationError($validator)]);
            }
            
            $user = new User;
            $user->role = $request->role;
            $user->first_name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->country = $request->country;
            $user->password = Hash::make($request->password);
            // Generate OTP for email verification
            $user->otp = rand(100000, 999999);
            $user->otp_sent_time = now();
            // email_verified_at remains null until OTP is verified
            $user->save();
            
            // Send OTP email
            try {
                EmailService::sendSignupOtp($user);
            } catch (\Exception $e) {
                \Log::error('Failed to send signup OTP email', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            }
            
            DB::commit();
            
            // Return response indicating verification is required (no token yet)
            return response()->json([
                'status' => true, 
                'requires_verification' => true,
                'message' => 'Registration successful! Please check your email for the verification code.',
                'data' => [
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'role' => $user->role,
                ]
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['status' => false, 'message' => showError($e)]);
        }
    }

    /**
     * Verify signup OTP and complete registration
     */
    public function verifySignupOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);
        
        if($validator->fails()){
            return response()->json(['status' => false, 'message' => 'Validation error', 'data' => validationError($validator)]);
        }
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found!']);
        }
        
        if ($user->email_verified_at) {
            return response()->json(['status' => false, 'message' => 'Email is already verified. Please login.']);
        }
        
        if ($user->otp != $request->otp) {
            return response()->json(['status' => false, 'message' => 'Invalid OTP!']);
        }
        
        // Check OTP expiry (10 minutes)
        if ($user->otp_sent_time && (strtotime(now()) - strtotime($user->otp_sent_time)) > 600) {
            return response()->json(['status' => false, 'message' => 'OTP has expired! Please request a new one.']);
        }
        
        // Mark email as verified and clear OTP
        $user->email_verified_at = now();
        $user->otp = null;
        $user->otp_sent_time = null;
        $user->save();
        
        // Generate token and log in user
        $token = JWTAuth::fromUser($user);
        
        $data = [
            'personal' => [
                'id' => $user->id,
                'role' => $user->role,
                'name' => $user->first_name,
                'phone' => $user->phone,
                'email' => $user->email,
                'country' => $user->country,
                'image' => img($user->image),
            ],
            'professional' => [
                'id' => $user->id,
                'professional_title' => $user->professional_title,
                'experience' => $user->experience,
                'language' => $user->language,
                'timezone' => $user->timezone,
                'about' => $user->about,
                'category_id' => $user->category_id,
                'programming_language_id' => $user->programming_language_id,
                'availability' => $user->availability,
                'profile_status' => $user->profile_status,
                'linkedin_link' => $user->linkedin_link,
                'portfolio_link' => $user->portfolio_link,
                'relevant_link' => $user->relevant_link,
            ]
        ];
        
        // Send welcome email
        try {
            EmailService::sendWelcome($user);
        } catch (\Exception $e) {
            \Log::error('Failed to send welcome email', ['error' => $e->getMessage(), 'user_id' => $user->id]);
        }
        
        return response()->json([
            'status' => true, 
            'access_token' => $token, 
            'message' => 'Email verified successfully! Welcome to The Code Helper.', 
            'data' => $data
        ]);
    }

    /**
     * Resend signup OTP
     */
    public function resendSignupOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        
        if($validator->fails()){
            return response()->json(['status' => false, 'message' => 'Validation error', 'data' => validationError($validator)]);
        }
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found!']);
        }
        
        if ($user->email_verified_at) {
            return response()->json(['status' => false, 'message' => 'Email is already verified. Please login.']);
        }
        
        // Check cooldown (30 seconds)
        if ($user->otp_sent_time && (strtotime(now()) - strtotime($user->otp_sent_time)) < 30) {
            $remaining = 30 - (strtotime(now()) - strtotime($user->otp_sent_time));
            return response()->json(['status' => false, 'message' => "Please wait {$remaining} seconds before requesting a new OTP."]);
        }
        
        // Generate new OTP
        $user->otp = rand(100000, 999999);
        $user->otp_sent_time = now();
        $user->save();
        
        // Send OTP email
        try {
            EmailService::sendSignupOtp($user);
        } catch (\Exception $e) {
            \Log::error('Failed to send signup OTP email', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            return response()->json(['status' => false, 'message' => 'Failed to send OTP. Please try again.']);
        }
        
        return response()->json(['status' => true, 'message' => 'OTP has been resent! This will be valid for 10 minutes.']);
    }

    public function sendVerificationLinkToEmail()
    {
        // DB::beginTransaction();
        // try{
            $validator = Validator::make(request()->all(), [
                    'email' => 'required',
                    'name' => 'required',
                    'role' => 'required|in:Freelancer,Client',
                    'phone' => 'required',
                    'country' => 'required',
                    'password' => 'required',
                    'term_and_condition' => 'required',
                ]
            );
            if($validator->fails()){
                return response()->json(['status' => false, 'message' => 'Validation error', 'data' => validationError($validator)]);
            }
            $user = UnverifiedUser::where('email', request()->email)->first();
            if(!$user){
                $user = new UnverifiedUser();
            }

            $user->role = request()->role;
            $user->first_name = request()->name;
            $user->phone = request()->phone;
            $user->email = request()->email;
            $user->country = request()->country;
            $user->password = Hash::make(request()->password);
            $user->token = generateRandomString();
            $user->save();
            $email = $user->email;
            $subject = 'Verify your email to complete the registration on The Code Helper';
            // Mail::send('emails.verify-email', ['user' => $user], function($q) use($email, $subject){
            //     $q->to('test11@yopmail.com')->subject($subject);
            // });
            Mail::send('emails.verify-email', [], function($q){
                $q->to('zaid1234@yopmail.com');
                $q->subject('Driver has created the order');
                // $q->attach($pdfPath, [
                //       'as' => 'order_'.$order->id.'.pdf',
                //       'mime' => 'application/pdf',
                //   ]);
              });
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Verification link has sent on your email.', 'data' => $user]);
        // }catch(\Exception $e){
        //     DB::rollback();
        //     return response()->json(['status' => false, 'message' => showError($e)]);
        // }
    }

    /**
     * login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, $type = null)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            ]
        );
        if($validator->fails()){
            return response()->json(['status' => false, 'message' => 'Validation error', 'data' => validationError($validator)]);
        }
        
        // Check if user exists and email is verified
        $user = User::where('email', $request->email)->first();
        if ($user && !$user->email_verified_at) {
            return response()->json([
                'status' => false, 
                'requires_verification' => true,
                'message' => 'Please verify your email before logging in.',
                'data' => ['email' => $user->email]
            ]);
        }
        
        if (!$token = auth()->guard('api')->attempt($validator->validated())) {
            return response()->json(['status' => false, 'message' => 'Email or password is incorrect']);
        }
        if($type == 'register'){
            return $token;
        }
        $user = User::where('email',$request->email)->first();
        $token = JWTAuth::fromUser($user);
        auth()->login($user);
        $data = [
            'personal' => [
                'id' => $user->id,
                'role' => $user->role,
                'name' => $user->first_name,
                'phone' => $user->phone,
                'email' => $user->email,
                'country' => $user->country,
                'image' => img($user->image),
                'stripe_account_id' => $user->stripe_account_id,
            ],
            'professional' => [
                'id' => $user->id,
                'professional_title' => $user->professional_title,
                'experience' => $user->experience,
                'language' => $user->language,
                'timezone' => $user->timezone,
                'about' => $user->about,
                'category_id' => $user->category_id,
                'programming_language_id' => $user->programming_language_id,
                'availability' => $user->availability,
                'linkedin_link' => $user->linkedin_link,
                'portfolio_link' => $user->portfolio_link,
                'relevant_link' => $user->relevant_link,
            ]
        ];
        return response()->json([
            'status' => true,
            'message' => 'Logged in successfully!',
            'access_token' => $token,
            'data' => $data
        ]);
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }

    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    /**
     * Get user profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth()->guard('api')->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }
}
