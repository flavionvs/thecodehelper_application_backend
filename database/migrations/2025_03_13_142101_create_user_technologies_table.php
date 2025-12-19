<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTechnologiesTable extends Migration
{
    public function up()
    {
        Schema::create('user_technologies', function (Blueprint $table) {
            $table->id();

            // FK to users is fine (users table exists early)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // No FK yet because technologies table is created later
            $table->unsignedBigInteger('technology_id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_technologies');
    }
}
