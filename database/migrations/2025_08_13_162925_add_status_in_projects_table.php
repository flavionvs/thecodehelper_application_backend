<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusInProjectsTable extends Migration
{
    public function up()
    {
        // ✅ status is already created in 2025_03_05_135507_create_projects_table.php
        // Do nothing to avoid duplicate column errors.
    }

    public function down()
    {
        // no-op
    }
}
