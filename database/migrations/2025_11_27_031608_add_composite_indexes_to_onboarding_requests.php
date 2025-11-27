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
            // Composite index for default view (My Requests sorted by date)
            $table->index(['teller_id', 'created_at']);

            // Composite index for status tabs (Pending, Approved, Rejected)
            $table->index(['teller_id', 'approval_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('teller_portal')->table('onboarding_requests', function (Blueprint $table) {
            $table->dropIndex(['teller_id', 'created_at']);
            $table->dropIndex(['teller_id', 'approval_status']);
        });
    }
};
