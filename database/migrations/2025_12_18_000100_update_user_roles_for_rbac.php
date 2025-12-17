<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'role')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("
                ALTER TABLE `users`
                MODIFY `role` ENUM('admin','branch_admin','teller','teller_unit') NOT NULL DEFAULT 'teller'
            ");

            DB::statement("
                ALTER TABLE `users`
                MODIFY `status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending'
            ");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'role')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("
                UPDATE `users`
                SET `role` = 'teller'
                WHERE `role` IN ('branch_admin','teller_unit')
            ");

            DB::statement("
                ALTER TABLE `users`
                MODIFY `role` ENUM('admin','teller') NOT NULL DEFAULT 'teller'
            ");

            DB::statement("
                ALTER TABLE `users`
                MODIFY `status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending'
            ");
        }
    }
};
