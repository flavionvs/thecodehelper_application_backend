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
            $table->string('type')->nullable()->after('message'); // e.g., 'payment', 'project', 'application', etc.
            $table->string('link')->nullable()->after('type'); // URL or route path to navigate to
            $table->unsignedBigInteger('reference_id')->nullable()->after('link'); // ID of related entity (project_id, application_id, etc.)
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
