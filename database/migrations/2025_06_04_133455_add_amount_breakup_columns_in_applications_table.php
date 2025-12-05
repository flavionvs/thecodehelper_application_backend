<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountBreakupColumnsInApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->decimal('admin_commission')->after('amount')->default(0);
            $table->decimal('admin_amount')->after('admin_commission')->default(0);
            $table->decimal('stripe_commission')->after('admin_amount')->default(0);
            $table->decimal('stripe_amount')->after('stripe_commission')->default(0);
            $table->decimal('stripe_fee')->after('stripe_amount')->default(0);
            $table->decimal('total_amount')->after('stripe_fee')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
        });
    }
}
