<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add missing columns only if they do not already exist
        if (!Schema::hasColumn('users', 'department_id') || !Schema::hasColumn('users', 'shift_id') || !Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'department_id')) {
                    $table->unsignedBigInteger('department_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('users', 'shift_id')) {
                    $table->unsignedBigInteger('shift_id')->nullable()->after('department_id');
                }
                if (!Schema::hasColumn('users', 'status')) {
                    $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('shift_id');
                }
                if (!Schema::hasColumn('users', 'hire_date')) {
                    $table->date('hire_date')->nullable()->after('status');
                }
                if (!Schema::hasColumn('users', 'employee_id')) {
                    $table->string('employee_id')->unique()->nullable()->after('hire_date');
                }
                if (!Schema::hasColumn('users', 'phone')) {
                    $table->string('phone')->nullable()->after('employee_id');
                }
                if (!Schema::hasColumn('users', 'address')) {
                    $table->text('address')->nullable()->after('phone');
                }
            });
        } else {
            // Ensure other optional columns exist
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'hire_date')) {
                    $table->date('hire_date')->nullable();
                }
                if (!Schema::hasColumn('users', 'employee_id')) {
                    $table->string('employee_id')->unique()->nullable();
                }
                if (!Schema::hasColumn('users', 'phone')) {
                    $table->string('phone')->nullable();
                }
                if (!Schema::hasColumn('users', 'address')) {
                    $table->text('address')->nullable();
                }
            });
        }

        // Try adding foreign key constraints safely
        try {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'department_id')) {
                    $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
                }
                if (Schema::hasColumn('users', 'shift_id')) {
                    $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('set null');
                }
            });
        } catch (\Throwable $e) {
            // Fallback to raw SQL in case of missing doctrine/dbal or other issues; ignore failures
            try {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'department_id')) {
                    // nothing
                } else {
                    \Illuminate\Support\Facades\DB::statement('ALTER TABLE `users` ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL');
                }
            } catch (\Throwable $e) {
                // ignore
            }
            try {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'shift_id')) {
                    // nothing
                } else {
                    \Illuminate\Support\Facades\DB::statement('ALTER TABLE `users` ADD CONSTRAINT `users_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts`(`id`) ON DELETE SET NULL');
                }
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['shift_id']);
            $table->dropColumn(['department_id', 'shift_id', 'status', 'hire_date', 'employee_id', 'phone', 'address']);
        });
    }
};
