<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * สร้างตารางเล็ก ๆ สำหรับเก็บสถานะคำขอ Onboarding แบบเรียบง่าย
     */
    public function up(): void
    {
        Schema::create('onboarding_request_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teller_id')->index()->comment('FK ไปยังผู้ใช้เทลเลอร์');
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->comment('สถานะของคำขอ');
            $table->text('remark')
                ->nullable()
                ->comment('เหตุผลเพิ่มเติมเมื่อถูก Reject');
            $table->timestamps();
        });
    }

    /**
     * ลบตารางเมื่อต้องการ rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('onboarding_request_flows');
    }
};
