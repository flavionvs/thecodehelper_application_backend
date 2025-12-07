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
        // If the categories table doesn't exist (like in this SQLite DB), skip this migration
        if (!Schema::hasTable('categories')) {
            return;
        }
    
        // First: Drop slug column if it exists
        if (Schema::hasColumn('categories', 'slug')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    
        // Then: Add slug column
        Schema::table('categories', function (Blueprint $table) {
            $table->text('slug')->nullable();
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
