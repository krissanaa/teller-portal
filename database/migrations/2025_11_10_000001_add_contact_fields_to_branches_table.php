<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            if (!Schema::hasColumn('branches', 'address')) {
                $table->text('address')->nullable()->after('name');
            }
            if (!Schema::hasColumn('branches', 'contact')) {
                $table->string('contact')->nullable()->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            if (Schema::hasColumn('branches', 'contact')) {
                $table->dropColumn('contact');
            }
            if (Schema::hasColumn('branches', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};
