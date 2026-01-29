<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FixPaymentStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:payment-statuses {--dry-run : Show what would be fixed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix inconsistent payment/project/application statuses after successful payments';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('=== DRY RUN MODE - No changes will be made ===');
        }

        $this->info('Scanning for inconsistent payment statuses...');

        // Find all succeeded payments
        $payments = Payment::where('paymentStatus', 'succeeded')
            ->whereNotNull('application_id')
            ->where('application_id', '>', 0)
            ->get();

        $this->info("Found {$payments->count()} succeeded payments to check.");

        $fixed = 0;
        $alreadyCorrect = 0;
        $errors = 0;

        foreach ($payments as $payment) {
            $this->line('');
            $this->info("Checking Payment #{$payment->id} (Intent: {$payment->paymentIntentId})");

            // Find application by id
            $application = Application::find($payment->application_id);

            if (!$application) {
                $this->warn("  ⚠ Application #{$payment->application_id} not found - skipping");
                $errors++;
                continue;
            }

            $this->line("  Application #{$application->id} - Current status: {$application->status}");

            // Find project
            $project = Project::find($application->project_id);

            if (!$project) {
                $this->warn("  ⚠ Project #{$application->project_id} not found - skipping");
                $errors++;
                continue;
            }

            $this->line("  Project #{$project->id} '{$project->title}'");
            $this->line("    - status: {$project->status}");
            $this->line("    - payment_status: {$project->payment_status}");
            $this->line("    - selected_application_id: {$project->selected_application_id}");

            $needsFix = false;
            $changes = [];

            // Check if application needs fixing (should be Approved or higher)
            if ($application->status === 'Pending') {
                $needsFix = true;
                $changes[] = "Application status: Pending → Approved";
            }

            // Check if project payment_status needs fixing
            if ($project->payment_status !== 'paid') {
                $needsFix = true;
                $changes[] = "Project payment_status: {$project->payment_status} → paid";
            }

            // Check if project status needs fixing (should be in_progress if not already completed)
            if ($project->status !== 'in_progress' && $project->status !== 'completed') {
                $needsFix = true;
                $changes[] = "Project status: {$project->status} → in_progress";
            }

            // Check if selected_application_id is set
            $appPk = $application->id;
            if (!$project->selected_application_id || $project->selected_application_id != $appPk) {
                $needsFix = true;
                $changes[] = "Project selected_application_id: {$project->selected_application_id} → {$appPk}";
            }

            if (!$needsFix) {
                $this->info("  ✓ Already correct");
                $alreadyCorrect++;
                continue;
            }

            $this->warn("  ✗ Needs fixing:");
            foreach ($changes as $change) {
                $this->line("    - {$change}");
            }

            if (!$dryRun) {
                try {
                    DB::transaction(function () use ($application, $project, $appPk) {
                        // Fix application status
                        if ($application->status === 'Pending') {
                            Application::where('id', $application->id)->update([
                                'status' => 'Approved',
                            ]);
                        }

                        // Fix project
                        $project->payment_status = 'paid';
                        if ($project->status !== 'completed') {
                            $project->status = 'in_progress';
                        }
                        $project->selected_application_id = $appPk;
                        $project->save();
                    });

                    $this->info("  ✓ Fixed!");
                    $fixed++;

                    Log::info('[FixPaymentStatuses] Fixed payment status', [
                        'payment_id' => $payment->id,
                        'application_id' => $application->id,
                        'project_id' => $project->id,
                    ]);
                } catch (\Exception $e) {
                    $this->error("  ✗ Error: {$e->getMessage()}");
                    $errors++;
                }
            } else {
                $fixed++;
            }
        }

        $this->line('');
        $this->info('=== Summary ===');
        $this->line("Total payments checked: {$payments->count()}");
        $this->line("Already correct: {$alreadyCorrect}");
        $this->line($dryRun ? "Would fix: {$fixed}" : "Fixed: {$fixed}");
        $this->line("Errors/Skipped: {$errors}");

        if ($dryRun && $fixed > 0) {
            $this->line('');
            $this->warn("Run without --dry-run to apply fixes:");
            $this->line("  php artisan fix:payment-statuses");
        }

        return 0;
    }
}
