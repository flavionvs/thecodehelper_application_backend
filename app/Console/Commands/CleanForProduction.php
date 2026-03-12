<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CleanForProduction extends Command
{
    protected $signature = 'db:clean-for-production
                            {--force : Actually delete data (without this flag, runs in dry-run mode)}
                            {--keep-blogs : Keep blog_posts table data}
                            {--keep-admin-email=* : Additional admin emails to preserve (besides role=Admin users)}';

    protected $description = 'Remove all test/demo user data while preserving system tables (categories, roles, technologies, blogs). Runs in dry-run mode by default.';

    // Tables with user/transactional data - deleted in this order (leaf → root)
    private array $cleanOrder = [
        'transactions',
        'payments',
        'application_statuses',
        'application_completion_attachments',
        'application_attachments',
        'applications',
        'notifications',
        'messages',
        'contact_queries',
        'user_technologies',
        'user_programming_languages',
        'user_languages',
        'user_langs',
        'projects',
        'unverified_users',
    ];

    // System tables - NEVER touched
    private array $systemTables = [
        'categories',
        'technologies',
        'programming_languages',
        'langs',
        'roles',
        'permissions',
        'model_has_roles',
        'role_has_permissions',
        'model_has_permissions',
        'blog_posts',
        'migrations',
        'failed_jobs',
        'personal_access_tokens',
        'password_resets',
        'basic_settings',
        'website_settings',
        'services',
        'verticals',
        'subcategories',
    ];

    public function handle(): int
    {
        $isDryRun = !$this->option('force');
        $keepBlogs = $this->option('keep-blogs');
        $extraAdminEmails = $this->option('keep-admin-email');

        $mode = $isDryRun ? '🔍 DRY-RUN MODE (no data will be deleted)' : '⚠️  LIVE MODE — DATA WILL BE PERMANENTLY DELETED';
        $this->newLine();
        $this->info("=== DB Clean for Production ===");
        $this->info($mode);
        $this->newLine();

        // Show current data counts
        $this->info("📊 Current data summary:");
        $this->showDataSummary();
        $this->newLine();

        // Show what will be preserved
        $adminUsers = DB::table('users')->where('role', 'Admin')->get(['id', 'name', 'email', 'role']);
        $this->info("🔒 Admin users that will be PRESERVED:");
        foreach ($adminUsers as $user) {
            $this->line("   - #{$user->id} {$user->name} ({$user->email}) [{$user->role}]");
        }

        if (!empty($extraAdminEmails)) {
            $extraUsers = DB::table('users')->whereIn('email', $extraAdminEmails)->get(['id', 'name', 'email', 'role']);
            foreach ($extraUsers as $user) {
                $this->line("   - #{$user->id} {$user->name} ({$user->email}) [{$user->role}] (extra)");
            }
        }

        $this->newLine();
        $this->info("🗑  Tables that will be CLEANED:");
        foreach ($this->cleanOrder as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                $this->line("   - {$table}: {$count} rows");
            }
        }
        $this->line("   - users: " . DB::table('users')->where('role', '!=', 'Admin')->count() . " non-admin rows");

        if (!$keepBlogs) {
            $blogCount = Schema::hasTable('blog_posts') ? DB::table('blog_posts')->count() : 0;
            if ($blogCount > 0) {
                $this->warn("   ⚠ blog_posts: {$blogCount} rows (use --keep-blogs to preserve)");
            }
        }

        $this->newLine();
        $this->info("🛡  Tables that will NOT be touched:");
        foreach ($this->systemTables as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                if ($table === 'blog_posts' && !$keepBlogs) continue;
                $this->line("   - {$table}: {$count} rows");
            }
        }

        if ($isDryRun) {
            $this->newLine();
            $this->warn("This was a DRY RUN. To actually delete data, run:");
            $this->warn("   php artisan db:clean-for-production --force");
            return 0;
        }

        // Confirm before live deletion
        $this->newLine();
        if (!$this->confirm('⚠️  ARE YOU SURE you want to permanently delete all test data? This CANNOT be undone.')) {
            $this->info("Aborted.");
            return 0;
        }

        if (!$this->confirm('🔴 FINAL CONFIRMATION: Type yes to proceed with deletion')) {
            $this->info("Aborted.");
            return 0;
        }

        // Perform the cleanup
        $this->newLine();
        $this->info("🚀 Starting cleanup...");

        // Collect admin user IDs to preserve
        $preserveUserIds = DB::table('users')->where('role', 'Admin')->pluck('id')->toArray();
        if (!empty($extraAdminEmails)) {
            $extraIds = DB::table('users')->whereIn('email', $extraAdminEmails)->pluck('id')->toArray();
            $preserveUserIds = array_unique(array_merge($preserveUserIds, $extraIds));
        }

        DB::beginTransaction();
        try {
            // Temporarily disable FK checks for clean truncation
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            foreach ($this->cleanOrder as $table) {
                if (!Schema::hasTable($table)) {
                    $this->line("   ⏭ {$table}: table not found, skipping");
                    continue;
                }
                $count = DB::table($table)->count();
                DB::table($table)->truncate();
                $this->line("   ✅ {$table}: {$count} rows deleted");
            }

            // Delete non-admin users (preserve admin accounts)
            if (!empty($preserveUserIds)) {
                $deleted = DB::table('users')->whereNotIn('id', $preserveUserIds)->delete();
                $this->line("   ✅ users: {$deleted} non-admin rows deleted ({$this->count($preserveUserIds)} admin accounts preserved)");
            } else {
                $this->warn("   ⚠ No admin users found! Skipping user deletion for safety.");
            }

            // Optionally clean blog_posts
            if (!$keepBlogs && Schema::hasTable('blog_posts')) {
                $blogCount = DB::table('blog_posts')->count();
                if ($blogCount > 0) {
                    DB::table('blog_posts')->truncate();
                    $this->line("   ✅ blog_posts: {$blogCount} rows deleted");
                }
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            DB::commit();

            $this->newLine();
            $this->info("✅ Database cleaned successfully!");
            $this->newLine();

            // Show final state
            $this->info("📊 Final data summary:");
            $this->showDataSummary();

        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            DB::rollBack();
            $this->error("❌ Cleanup failed: " . $e->getMessage());
            $this->error("Database was NOT modified (rolled back).");
            return 1;
        }

        return 0;
    }

    private function count(array $arr): int
    {
        return \count($arr);
    }

    private function showDataSummary(): void
    {
        $tables = array_merge($this->cleanOrder, ['users', 'blog_posts'], $this->systemTables);
        $tables = array_unique($tables);

        $rows = [];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                $type = in_array($table, $this->systemTables) ? 'System' : 'User Data';
                if ($table === 'users') $type = 'User Data';
                if ($table === 'blog_posts') $type = 'Content';
                $rows[] = [$table, $count, $type];
            }
        }

        $this->table(['Table', 'Rows', 'Type'], $rows);
    }
}
