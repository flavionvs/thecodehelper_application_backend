<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendTestEmails extends Command
{
    protected $signature = 'email:test {email : The email address to send test emails to}';
    protected $description = 'Send all email templates as test emails to a given address';

    public function handle()
    {
        $to = $this->argument('email');
        $this->info("Sending all test emails to: {$to}");
        $this->newLine();

        $results = [];

        // 1. Verify Email (OTP)
        $results[] = $this->sendTemplate('verify-email', '✉️ Verify Your Email - The Code Helper', $to, [
            'user' => (object) [
                'first_name' => 'Ranjan',
                'email' => $to,
                'otp' => '482916',
            ],
        ]);

        // 2. Welcome
        $results[] = $this->sendTemplate('welcome', '👋 Welcome to The Code Helper!', $to, [
            'user' => (object) [
                'first_name' => 'Ranjan',
                'email' => $to,
            ],
        ]);

        // 3. Project Created
        $results[] = $this->sendTemplate('project-created', '🚀 Project Created Successfully - The Code Helper', $to, [
            'client_name' => 'Ranjan',
            'client_email' => $to,
            'project_title' => 'E-Commerce Website Redesign',
            'project_id' => 101,
            'project_description' => 'A full redesign of the existing e-commerce platform with modern UI/UX, responsive design, and improved checkout flow.',
            'project_budget' => '2500.00',
            'project_slug' => 'e-commerce-website-redesign',
        ]);

        // 4. Application Approved (to freelancer)
        $results[] = $this->sendTemplate('application-approved', '🚀 Payment Received – Start Working on Your Project - The Code Helper', $to, [
            'freelancer_name' => 'Ranjan',
            'freelancer_email' => $to,
            'project_title' => 'E-Commerce Website Redesign',
            'project_id' => 101,
            'project_description' => 'A full redesign of the existing e-commerce platform with modern UI/UX.',
            'client_name' => 'John Smith',
            'client_email' => 'john@example.com',
            'budget' => '2500.00',
        ]);

        // 5. Payment Successful (to client)
        $results[] = $this->sendTemplate('payment-successful', '✅ Payment Confirmed - The Code Helper', $to, [
            'client_name' => 'Ranjan',
            'client_email' => $to,
            'project_title' => 'E-Commerce Website Redesign',
            'project_id' => 101,
            'project_description' => 'A full redesign of the existing e-commerce platform.',
            'freelancer_name' => 'Jane Doe',
            'freelancer_email' => 'jane@example.com',
            'amount' => '2500.00',
        ]);

        // 6. New Application (to client)
        $results[] = $this->sendTemplate('new-application', '📬 New Application Received - The Code Helper', $to, [
            'client_name' => 'Ranjan',
            'client_email' => $to,
            'project_title' => 'E-Commerce Website Redesign',
            'project_id' => 101,
            'project_description' => 'A full redesign of the existing e-commerce platform.',
            'freelancer_name' => 'Jane Doe',
            'freelancer_email' => 'jane@example.com',
            'amount' => '2000.00',
        ]);

        // 7. Completion Requested (to client)
        $results[] = $this->sendTemplate('completion-requested', '📋 Project Completion Requested - The Code Helper', $to, [
            'client_name' => 'Ranjan',
            'client_email' => $to,
            'project_title' => 'E-Commerce Website Redesign',
            'project_id' => 101,
            'freelancer_name' => 'Jane Doe',
            'freelancer_email' => 'jane@example.com',
        ]);

        // 8. Project Completed (to both)
        $results[] = $this->sendTemplate('project-completed', '🏆 Project Completed - The Code Helper', $to, [
            'user_name' => 'Ranjan',
            'user_email' => $to,
            'project_title' => 'E-Commerce Website Redesign',
            'project_id' => 101,
            'amount' => '2500.00',
            'message' => 'The project has been marked as completed. Great work! Thank you for using The Code Helper.',
        ]);

        // 9. Cancellation Approved - Refund
        $results[] = $this->sendTemplate('cancellation-approved', '💰 Cancellation Approved – Refund Processed - The Code Helper', $to, [
            'user_name' => 'Ranjan',
            'project_title' => 'E-Commerce Website Redesign',
            'project_id' => 101,
            'type' => 'refund',
            'amount' => 2025.00,
            'email_message' => 'Your cancellation request for "E-Commerce Website Redesign" has been approved. A refund of $2,025.00 has been processed to your original payment method (after deducting cancellation and processing fees).',
        ]);

        // 10. Cancellation Approved - Transfer (bonus: show both variants)
        $results[] = $this->sendTemplate('cancellation-approved', '✅ Cancellation Approved – Payment Transferred - The Code Helper', $to, [
            'user_name' => 'Ranjan',
            'project_title' => 'E-Commerce Website Redesign',
            'project_id' => 101,
            'type' => 'transfer',
            'amount' => 1875.00,
            'email_message' => 'The project "E-Commerce Website Redesign" has been cancelled, but your payment of $1,875.00 has been transferred for the work completed (after deducting cancellation and processing fees).',
        ]);

        $this->newLine();
        $passed = count(array_filter($results));
        $total = count($results);
        $this->info("Done! {$passed}/{$total} emails sent successfully.");

        return $passed === $total ? 0 : 1;
    }

    private function sendTemplate(string $template, string $subject, string $to, array $data): bool
    {
        $label = str_replace('emails.', '', $template);
        $this->output->write("  [{$label}] {$subject} ... ");

        try {
            Mail::send("emails.{$template}", $data, function ($message) use ($to, $subject) {
                $message->to($to)->subject("[TEST] {$subject}");
            });
            $this->info('✓ Sent');
            return true;
        } catch (\Exception $e) {
            $this->error('✗ FAILED: ' . $e->getMessage());
            Log::error("Test email failed for {$template}", ['error' => $e->getMessage()]);
            return false;
        }
    }
}
