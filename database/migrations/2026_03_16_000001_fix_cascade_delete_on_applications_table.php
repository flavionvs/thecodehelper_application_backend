<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixCascadeDeleteOnApplicationsTable extends Migration
{
    /**
     * The original SQL dump created the applications FK without ON DELETE CASCADE.
     * This migration drops and re-creates the constraint with cascade rules
     * so that deleting a project properly removes its applications (and their
     * downstream attachments, statuses, payments, and transactions).
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign('applications_project_id_foreign');
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->dropForeign('applications_user_id_foreign');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects');

            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }
}
