<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'teller_id')) {
                $table->string('teller_id', 10)->unique()->after('id');
            }
        });

        // Add FK from onboarding_requests.teller_id -> users.teller_id if both columns exist
        if (Schema::hasTable('onboarding_requests') && Schema::hasColumn('onboarding_requests', 'teller_id')) {
            Schema::table('onboarding_requests', function (Blueprint $table) {
                try {
                    $table->foreign('teller_id')->references('teller_id')->on('users')->cascadeOnDelete();
                } catch (\Throwable $e) {
                    // Ignore if constraint already exists
                }
            });
        }
    }

    public function down(): void
    {
        // Drop FK on onboarding_requests if present
        if (Schema::hasTable('onboarding_requests') && Schema::hasColumn('onboarding_requests', 'teller_id')) {
            Schema::table('onboarding_requests', function (Blueprint $table) {
                try { $table->dropForeign(['teller_id']); } catch (\Throwable $e) {}
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'teller_id')) {
                $table->dropColumn('teller_id');
            }
        });
    }
};
