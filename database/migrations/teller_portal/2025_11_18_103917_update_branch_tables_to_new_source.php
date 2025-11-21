<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_portal';

    public function up(): void
    {
        $driver = DB::connection($this->connection)->getDriverName();

        if ($driver !== 'mysql') {
            return;
        }

        $connection = DB::connection($this->connection);

        // Ensure the new branch table has a proper primary key to reference.
        $connection->statement('ALTER TABLE `branch` MODIFY COLUMN `id` BIGINT UNSIGNED NOT NULL');

        $hasPrimary = $connection->select("SHOW KEYS FROM `branch` WHERE Key_name = 'PRIMARY'");
        if (empty($hasPrimary)) {
            $connection->statement('ALTER TABLE `branch` ADD PRIMARY KEY (`id`)');
        }

        $connection->statement('ALTER TABLE `branch` MODIFY COLUMN `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');

        Schema::connection($this->connection)->table('onboarding_requests', function (Blueprint $table) {
            $table->dropForeign('onboarding_requests_branch_id_foreign');
        });

        $connection->statement('ALTER TABLE `onboarding_requests` MODIFY COLUMN `branch_id` BIGINT UNSIGNED NULL');

        Schema::connection($this->connection)->table('onboarding_requests', function (Blueprint $table) {
            $table->foreign('branch_id')
                ->references('id')
                ->on('branch')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        $driver = DB::connection($this->connection)->getDriverName();

        if ($driver !== 'mysql') {
            return;
        }

        $connection = DB::connection($this->connection);

        Schema::connection($this->connection)->table('onboarding_requests', function (Blueprint $table) {
            $table->dropForeign('onboarding_requests_branch_id_foreign');
        });

        $connection->statement('ALTER TABLE `onboarding_requests` MODIFY COLUMN `branch_id` BIGINT UNSIGNED NULL');

        Schema::connection($this->connection)->table('onboarding_requests', function (Blueprint $table) {
            $table->foreign('branch_id')
                ->references('id')
                ->on('branches')
                ->nullOnDelete();
        });

        $connection->statement('ALTER TABLE `branch` MODIFY COLUMN `id` INT NOT NULL');
        $connection->statement('ALTER TABLE `branch` DROP PRIMARY KEY');
    }
};
