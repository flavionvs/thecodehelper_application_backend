<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send application approved email to freelancer
     */
    public static function sendApplicationApproved($freelancer, $project, $client, $amount)
    {
        try {
            Mail::send('emails.application-approved', [
                'freelancer_name' => $freelancer->first_name,
                'freelancer_email' => $freelancer->email,
                'project_title' => $project->title,
                'project_id' => $project->id,
                'project_description' => $project->description,
                'client_name' => $client->first_name,
                'client_email' => $client->email,
                'budget' => $amount,
            ], function ($message) use ($freelancer) {
                $message->to($freelancer->email)
                    ->subject('🚀 Payment Received – Start Working on Your Project - The Code Helper');
            });
            
            Log::info('Application approved email sent', ['freelancer_id' => $freelancer->id, 'project_id' => $project->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send application approved email', [
                'error' => $e->getMessage(),
                'freelancer_id' => $freelancer->id ?? null,
            ]);
            return false;
        }
    }

    /**
     * Send payment successful email to client
     */
    public static function sendPaymentSuccessful($client, $project, $freelancer, $amount)
    {
        try {
            Mail::send('emails.payment-successful', [
                'client_name' => $client->first_name,
                'client_email' => $client->email,
                'project_title' => $project->title,
                'project_id' => $project->id,
                'project_description' => $project->description,
                'freelancer_name' => $freelancer->first_name,
                'freelancer_email' => $freelancer->email,
                'amount' => $amount,
            ], function ($message) use ($client) {
                $message->to($client->email)
                    ->subject('✅ Payment Confirmed - The Code Helper');
            });
            
            Log::info('Payment successful email sent', ['client_id' => $client->id, 'project_id' => $project->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send payment successful email', [
                'error' => $e->getMessage(),
                'client_id' => $client->id ?? null,
            ]);
            return false;
        }
    }

    /**
     * Send new application email to client
     */
    public static function sendNewApplication($client, $project, $freelancer, $amount)
    {
        try {
            Mail::send('emails.new-application', [
                'client_name' => $client->first_name,
                'client_email' => $client->email,
                'project_title' => $project->title,
                'project_id' => $project->id,
                'project_description' => $project->description,
                'freelancer_name' => $freelancer->first_name,
                'freelancer_email' => $freelancer->email,
                'amount' => $amount,
            ], function ($message) use ($client) {
                $message->to($client->email)
                    ->subject('📬 New Application Received - The Code Helper');
            });
            
            Log::info('New application email sent', ['client_id' => $client->id, 'project_id' => $project->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send new application email', [
                'error' => $e->getMessage(),
                'client_id' => $client->id ?? null,
            ]);
            return false;
        }
    }

    /**
     * Send completion requested email to client
     */
    public static function sendCompletionRequested($client, $project, $freelancer)
    {
        try {
            Mail::send('emails.completion-requested', [
                'client_name' => $client->first_name,
                'client_email' => $client->email,
                'project_title' => $project->title,
                'project_id' => $project->id,
                'freelancer_name' => $freelancer->first_name,
                'freelancer_email' => $freelancer->email,
            ], function ($message) use ($client) {
                $message->to($client->email)
                    ->subject('📋 Project Completion Requested - The Code Helper');
            });
            
            Log::info('Completion requested email sent', ['client_id' => $client->id, 'project_id' => $project->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send completion requested email', [
                'error' => $e->getMessage(),
                'client_id' => $client->id ?? null,
            ]);
            return false;
        }
    }

    /**
     * Send project completed email to both parties
     */
    public static function sendProjectCompleted($user, $project, $amount = null, $customMessage = null)
    {
        try {
            Mail::send('emails.project-completed', [
                'user_name' => $user->first_name,
                'user_email' => $user->email,
                'project_title' => $project->title,
                'project_id' => $project->id,
                'amount' => $amount,
                'message' => $customMessage,
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('🏆 Project Completed - The Code Helper');
            });
            
            Log::info('Project completed email sent', ['user_id' => $user->id, 'project_id' => $project->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send project completed email', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? null,
            ]);
            return false;
        }
    }

    /**
     * Send welcome email to new user
     */
    public static function sendWelcome($user)
    {
        try {
            Mail::send('emails.welcome', [
                'user' => $user,
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('👋 Welcome to The Code Helper!');
            });
            
            Log::info('Welcome email sent', ['user_id' => $user->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? null,
            ]);
            return false;
        }
    }

    /**
     * Send forgot password OTP email
     */
    public static function sendForgotPassword($user)
    {
        try {
            Mail::send('emails.forgot-password', [
                'user' => $user,
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('🔐 Password Reset Code - The Code Helper');
            });
            
            Log::info('Forgot password email sent', ['user_id' => $user->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send forgot password email', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? null,
            ]);
            return false;
        }
    }

    /**
     * Send signup OTP verification email
     */
    public static function sendSignupOtp($user)
    {
        try {
            Mail::send('emails.verify-email', [
                'user' => $user,
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('✉️ Verify Your Email - The Code Helper');
            });
            
            Log::info('Signup OTP email sent', ['user_id' => $user->id, 'email' => $user->email]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send signup OTP email', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? null,
                'email' => $user->email ?? null,
            ]);
            return false;
        }
    }

    /**
     * Send project created notification email to client
     */
    public static function sendProjectCreated($client, $project)
    {
        try {
            Mail::send('emails.project-created', [
                'client_name' => $client->first_name,
                'client_email' => $client->email,
                'project_title' => $project->title,
                'project_id' => $project->id,
                'project_description' => \Illuminate\Support\Str::limit(strip_tags($project->description), 200),
                'project_budget' => $project->budget,
                'project_slug' => $project->slug,
            ], function ($message) use ($client) {
                $message->to($client->email)
                    ->subject('🚀 Project Created Successfully - The Code Helper');
            });
            
            Log::info('Project created email sent', ['client_id' => $client->id, 'project_id' => $project->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send project created email', [
                'error' => $e->getMessage(),
                'client_id' => $client->id ?? null,
            ]);
            return false;
        }
    }
}
