<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdInPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {

            // ✅ Add user_id with correct type and FK (matches users.id)
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('application_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {

            // Drop FK then column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

        });
    }
}
