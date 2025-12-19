<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLangsTable extends Migration
{
    public function up()
    {
        Schema::create('user_langs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // No FK yet (langs table may run later)
            $table->unsignedBigInteger('lang_id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_langs');
    }
}
