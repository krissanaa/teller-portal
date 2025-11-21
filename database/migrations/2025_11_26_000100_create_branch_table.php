<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_portal';

    public function up(): void
    {
        if (Schema::connection($this->connection)->hasTable('branch')) {
            return;
        }

        Schema::connection($this->connection)->create('branch', function (Blueprint $table) {
            $table->id();
            $table->string('BRANCH_CODE', 50)->unique();
            $table->string('BRANCH_NAME');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('branch');
    }
};
