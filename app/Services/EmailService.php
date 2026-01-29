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
                'freelancer_name' => $freelancer->name,
                'project_title' => $project->title,
                'client_name' => $client->name,
                'budget' => $amount,
            ], function ($message) use ($freelancer) {
                $message->to($freelancer->email)
                    ->subject('🎉 Your Application Has Been Approved - The Code Helper');
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
                'client_name' => $client->name,
                'project_title' => $project->title,
                'freelancer_name' => $freelancer->name,
                'amount' => $amount,
            ], function ($message) use ($client) {
                $message->to($client->email)
                    ->subject('✅ Payment Successful - The Code Helper');
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
                'client_name' => $client->name,
                'project_title' => $project->title,
                'freelancer_name' => $freelancer->name,
                'amount' => $amount,
                'project_id' => $project->id,
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
                'client_name' => $client->name,
                'project_title' => $project->title,
                'freelancer_name' => $freelancer->name,
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
                'user_name' => $user->name,
                'project_title' => $project->title,
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
}
