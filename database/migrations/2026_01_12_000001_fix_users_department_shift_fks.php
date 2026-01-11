<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure columns exist with correct type
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'shift_id')) {
                $table->unsignedBigInteger('shift_id')->nullable()->after('department_id');
            }
        });

        // Attempt to add foreign key constraints; ignore if already present or fails
        try {
            Schema::table('users', function (Blueprint $table) {
                // Only add FK if not present
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $indexes = $sm->listTableConstraints('users');
                // add department fk
                if (!array_key_exists('users_department_id_foreign', $indexes)) {
                    $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
                }
                if (!array_key_exists('users_shift_id_foreign', $indexes)) {
                    $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('set null');
                }
            });
        } catch (\Throwable $e) {
            // As fallback for environments without doctrine/dbal or where constraints listing isn't available
            try {
                DB::statement('ALTER TABLE `users` ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL');
            } catch (\Throwable $e) {
                // ignore
            }
            try {
                DB::statement('ALTER TABLE `users` ADD CONSTRAINT `users_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts`(`id`) ON DELETE SET NULL');
            } catch (\Throwable $e) {
                // ignore
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys if they exist
        Schema::table('users', function (Blueprint $table) {
            try { $table->dropForeign(['department_id']); } catch (\Throwable $e) { }
            try { $table->dropForeign(['shift_id']); } catch (\Throwable $e) { }

            // Optionally drop columns if present
            if (Schema::hasColumn('users', 'department_id')) {
                try { $table->dropColumn('department_id'); } catch (\Throwable $e) { }
            }
            if (Schema::hasColumn('users', 'shift_id')) {
                try { $table->dropColumn('shift_id'); } catch (\Throwable $e) { }
            }
        });
    }
};