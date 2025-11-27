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
        Schema::connection('teller_portal')->table('onboarding_requests', function (Blueprint $table) {
            // $table->index('teller_id'); // Already exists
            $table->index('created_at');
            $table->index('approval_status');
        });

        Schema::connection('teller_portal')->table('branch', function (Blueprint $table) {
            $table->index('BRANCH_NAME');
        });

        Schema::connection('teller_portal')->table('branch_unit', function (Blueprint $table) {
            $table->index('unit_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('teller_portal')->table('onboarding_requests', function (Blueprint $table) {
            $table->dropIndex(['teller_id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['approval_status']);
        });

        Schema::connection('teller_portal')->table('branch', function (Blueprint $table) {
            $table->dropIndex(['BRANCH_NAME']);
        });

        Schema::connection('teller_portal')->table('branch_unit', function (Blueprint $table) {
            $table->dropIndex(['unit_name']);
        });
    }
};
