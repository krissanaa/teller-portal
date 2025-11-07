<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('onboarding_requests', function (Blueprint $table) {
            $table->id();
            $table->string('refer_code')->unique();
            // Use teller_id as a string to preserve leading zeros (FK added in later migration)
            $table->string('teller_id', 10);
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();

            $table->string('store_name');
            $table->string('store_address');
            $table->string('business_type');
            $table->string('pos_serial')->nullable();
            $table->string('bank_account')->nullable();
            $table->date('installation_date')->nullable();
            $table->enum('store_status',['new','active','inactive'])->default('new');
            $table->enum('approval_status',['pending','approved','rejected'])->default('pending');
            $table->text('admin_remark')->nullable();

            $table->timestamps();
            $table->json('attachments')->nullable();

            // index for teller_id lookups
            $table->index('teller_id');

        });
    }

    public function down(): void {
        Schema::dropIfExists('onboarding_requests');
    }
};
