<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_portal';

    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('status')->default('active')->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
