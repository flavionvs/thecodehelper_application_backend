<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkTypeToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('notifications', 'type')) {
                $table->string('type')->nullable()->after('message');
            }
            if (!Schema::hasColumn('notifications', 'link')) {
                $table->string('link')->nullable()->after('type');
            }
            if (!Schema::hasColumn('notifications', 'reference_id')) {
                $table->unsignedBigInteger('reference_id')->nullable()->after('link');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['type', 'link', 'reference_id']);
        });
    }
}
