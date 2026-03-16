<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixCascadeDeleteOnApplicationsTable extends Migration
{
    /**
     * The live DB may have FK constraints without ON DELETE CASCADE.
     * This migration drops and re-creates them with cascade rules using raw SQL
     * to avoid constraint-name mismatches.
     */
    public function up()
    {
        // Find and drop the existing project_id FK (whatever its name is)
        $fks = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'applications'
              AND COLUMN_NAME = 'project_id'
              AND REFERENCED_TABLE_NAME = 'projects'
        ");

        foreach ($fks as $fk) {
            DB::statement("ALTER TABLE `applications` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
        }

        // Re-create with CASCADE
        DB::statement("
            ALTER TABLE `applications`
            ADD CONSTRAINT `applications_project_id_foreign`
            FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
            ON DELETE CASCADE ON UPDATE CASCADE
        ");

        // Find and drop the existing user_id FK (whatever its name is)
        $fks = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'applications'
              AND COLUMN_NAME = 'user_id'
              AND REFERENCED_TABLE_NAME = 'users'
        ");

        foreach ($fks as $fk) {
            DB::statement("ALTER TABLE `applications` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
        }

        // Re-create with CASCADE
        DB::statement("
            ALTER TABLE `applications`
            ADD CONSTRAINT `applications_user_id_foreign`
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
            ON DELETE CASCADE ON UPDATE CASCADE
        ");
    }

    public function down()
    {
        // Revert to non-cascading FKs
        DB::statement("ALTER TABLE `applications` DROP FOREIGN KEY `applications_project_id_foreign`");
        DB::statement("
            ALTER TABLE `applications`
            ADD CONSTRAINT `applications_project_id_foreign`
            FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
        ");

        DB::statement("ALTER TABLE `applications` DROP FOREIGN KEY `applications_user_id_foreign`");
        DB::statement("
            ALTER TABLE `applications`
            ADD CONSTRAINT `applications_user_id_foreign`
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ");
    }
}
