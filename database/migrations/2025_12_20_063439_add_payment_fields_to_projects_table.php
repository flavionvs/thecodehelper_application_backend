<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            if (!Schema::hasColumn('projects', 'payment_status')) {
                $table->string('payment_status')->default('unpaid')->after('user_id');
            }

            if (!Schema::hasColumn('projects', 'selected_application_id')) {
                $table->unsignedBigInteger('selected_application_id')->nullable()->after('payment_status');
            }

        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            if (Schema::hasColumn('projects', 'selected_application_id')) {
                $table->dropColumn('selected_application_id');
            }

            if (Schema::hasColumn('projects', 'payment_status')) {
                $table->dropColumn('payment_status');
            }

        });
    }
};
