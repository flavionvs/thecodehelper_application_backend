<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // ✅ Match applications.id (bigint unsigned) and create FK once
            $table->foreignId('application_id')
                  ->constrained('applications')
                  ->cascadeOnDelete();

            $table->decimal('amount', 10, 2)->nullable();
            $table->string('paymentIntentId')->nullable();
            $table->string('paymentStatus')->nullable();
            $table->text('paymentDetails')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
