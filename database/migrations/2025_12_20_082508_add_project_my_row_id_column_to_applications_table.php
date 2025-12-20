<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectMyRowIdColumnToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'project_my_row_id')) {
                $table->unsignedBigInteger('project_my_row_id')->nullable()->index();
            }
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            if (Schema::hasColumn('applications', 'project_my_row_id')) {
                $table->dropColumn('project_my_row_id');
            }
        });
    }
}
