<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // User who created the project
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Category (no FK yet because categories table isn't present)
            $table->unsignedBigInteger('category_id');

            $table->text('title');
            $table->text('description')->nullable();
            $table->string('budget')->nullable();
            $table->text('attachment')->nullable();
            $table->text('tags')->nullable();

            // Workflow fields
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('selected_application_id')->nullable();
            $table->string('payment_status')->default('unpaid');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
