<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLanguagesTable extends Migration
{
    public function up()
    {
        Schema::create('user_languages', function (Blueprint $table) {
            $table->id();

            // ✅ Must match users.id (bigint unsigned)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // ⚠️ Keep as plain column for now (FK can be added later)
            $table->unsignedBigInteger('language_id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_languages');
    }
}