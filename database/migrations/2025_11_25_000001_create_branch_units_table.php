<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_portal';

    public function up(): void
    {
        if (!Schema::connection($this->connection)->hasTable('branch_unit')) {
            Schema::connection($this->connection)->create('branch_unit', function (Blueprint $table) {
                $table->id();
                $table->integer('branch_id')->index();
                $table->string('unit_code', 50)->unique();
                $table->string('unit_name');
            });
        }

        if (!Schema::connection($this->connection)->hasColumn('onboarding_requests', 'unit_id')) {
            Schema::connection($this->connection)->table('onboarding_requests', function (Blueprint $table) {
                $table->unsignedBigInteger('unit_id')->nullable()->after('branch_id');
                $table->foreign('unit_id')
                    ->references('id')
                    ->on('branch_unit')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::connection($this->connection)->hasColumn('onboarding_requests', 'unit_id')) {
            Schema::connection($this->connection)->table('onboarding_requests', function (Blueprint $table) {
                $table->dropForeign(['unit_id']);
                $table->dropColumn('unit_id');
            });
        }

        Schema::connection($this->connection)->dropIfExists('branch_unit');
    }
};
