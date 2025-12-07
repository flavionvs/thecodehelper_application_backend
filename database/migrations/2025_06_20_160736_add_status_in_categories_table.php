<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusInCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // If the categories table doesn't exist, skip this migration
        if (!Schema::hasTable('categories')) {
            return;
        }
    
        // First: Drop status column if it exists
        if (Schema::hasColumn('categories', 'status')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    
        // Then: Add status column
        Schema::table('categories', function (Blueprint $table) {
            $table->text('status')->nullable();
        });
    }

    public function down()
    {
        // Rollback: Remove the status column
        if (Schema::hasColumn('categories', 'status')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
