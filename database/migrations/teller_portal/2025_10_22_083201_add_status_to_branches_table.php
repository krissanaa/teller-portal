<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_portal';

    public function up(): void
    {
        if (! Schema::connection($this->connection)->hasTable('branches') ||
            Schema::connection($this->connection)->hasColumn('branches', 'status')) {
            return;
        }

        Schema::connection($this->connection)->table('branches', function (Blueprint $table) {
            $table->string('status')->default('active')->after('name');
        });
    }

    public function down(): void
    {
        if (! Schema::connection($this->connection)->hasTable('branches') ||
            ! Schema::connection($this->connection)->hasColumn('branches', 'status')) {
            return;
        }

        Schema::connection($this->connection)->table('branches', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
