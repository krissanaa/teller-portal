<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_portal';

    public function up(): void
    {
        Schema::table('onboarding_requests', function (Blueprint $table) {
            $table->string('attachments')->nullable()->after('admin_remark');
        });
    }

    public function down(): void
    {
        Schema::table('onboarding_requests', function (Blueprint $table) {
            $table->dropColumn('attachments');
        });
    }
};
