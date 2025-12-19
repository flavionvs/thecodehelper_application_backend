<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // ✅ Define FK once (and match users.id)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // ✅ Define FK once (and match payments.id)
            $table->foreignId('payment_id')
                  ->constrained('payments')
                  ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}

