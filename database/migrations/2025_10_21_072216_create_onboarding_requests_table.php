<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('onboarding_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ref_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('shop_name');
            $table->string('address');
            $table->string('business_type');
            $table->string('pos_serial');
            $table->string('bank_account');
            $table->date('install_date');
            $table->string('branch')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onboarding_requests');
    }
};
