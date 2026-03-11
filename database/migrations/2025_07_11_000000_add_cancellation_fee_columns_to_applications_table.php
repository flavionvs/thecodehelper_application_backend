<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'cancellation_fee')) {
                $table->decimal('cancellation_fee', 10, 2)->nullable()->after('cancel_reason');
            }
            if (!Schema::hasColumn('applications', 'stripe_processing_fee')) {
                $table->decimal('stripe_processing_fee', 10, 2)->nullable()->after('cancellation_fee');
            }
            if (!Schema::hasColumn('applications', 'refund_amount')) {
                $table->decimal('refund_amount', 10, 2)->nullable()->after('stripe_processing_fee');
            }
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['cancellation_fee', 'stripe_processing_fee', 'refund_amount']);
        });
    }
};
