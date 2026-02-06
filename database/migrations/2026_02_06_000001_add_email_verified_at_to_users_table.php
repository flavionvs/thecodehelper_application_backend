<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds email_verified_at column for OTP verification during signup.
     * Existing users are marked as verified (since they registered before this feature).
     */
    public function up()
    {
        // Add email_verified_at column if it doesn't exist
        if (!Schema::hasColumn('users', 'email_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            });
            
            // Mark all existing users as verified (they were registered before OTP verification was required)
            DB::table('users')->whereNull('email_verified_at')->update([
                'email_verified_at' => DB::raw('created_at')
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
    }
};
