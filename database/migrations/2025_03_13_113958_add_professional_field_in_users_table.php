<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfessionalFieldInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('professional_title')->after('country')->nullable();
            $table->string('experience')->after('professional_title')->nullable();
            $table->string('language')->after('experience')->nullable();
            $table->string('timezone')->after('language')->nullable();
            $table->text('about')->after('timezone')->nullable();            
            $table->string('availability')->after('about')->nullable();
            $table->text('linkedin_link')->after('availability')->nullable();
            $table->text('portfolio_link')->after('linkedin_link')->nullable();
            $table->text('relevant_link')->after('portfolio_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
