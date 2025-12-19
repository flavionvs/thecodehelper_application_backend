<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProgrammingLanugagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_programming_languages', function (Blueprint $table) {
            $table->id();

            // ✅ Must match users.id (bigint unsigned)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // ⚠️ Keep as plain column for now (FK can be added later)
            $table->unsignedBigInteger('programming_language_id');

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
        Schema::dropIfExists('user_programming_languages');
    }
}
