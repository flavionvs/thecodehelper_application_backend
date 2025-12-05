<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugInCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First: Drop slug column if it exists
        if (Schema::hasColumn('categories', 'slug')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }

        // Second: Add new slug column
        Schema::table('categories', function (Blueprint $table) {
            $table->text('slug')->after('name')->nullable();
        });
    }

    public function down()
    {
        // Rollback: Remove the slug column
        if (Schema::hasColumn('categories', 'slug')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
}
