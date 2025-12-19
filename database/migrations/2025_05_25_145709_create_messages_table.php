<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            // ✅ Laravel standard primary key (bigint unsigned)
            $table->id();

            // ✅ Must match users.id (bigint unsigned)
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');

            $table->text('message')->nullable();
            $table->text('file')->nullable();
            $table->integer('is_read')->default(0);

            // ✅ Foreign keys
            $table->foreign('from')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('to')->references('id')->on('users')->cascadeOnDelete();

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
        Schema::dropIfExists('messages');
    }
}

