<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('onboarding_requests', function (Blueprint $table) {
        // add string teller_id if not exists (to preserve leading zeros)
        if (!Schema::hasColumn('onboarding_requests', 'teller_id')) {
            $table->string('teller_id', 10)
                  ->after('id')
                  ->nullable();
            // add FK to users.teller_id if the users column exists
            if (Schema::hasColumn('users', 'teller_id')) {
                $table->foreign('teller_id')->references('teller_id')->on('users')->cascadeOnDelete();
            }
        }

        // if you previously added a wrong "name" foreign key, drop it
        if (Schema::hasColumn('onboarding_requests', 'name')) {
            // drop FK then column (guard with try/catch in prod if uncertain)
            $table->dropForeign(['name']);
            $table->dropColumn('name');
        }
    });
}

public function down()
{
    Schema::table('onboarding_requests', function (Blueprint $table) {
        if (Schema::hasColumn('onboarding_requests', 'teller_id')) {
            // drop FK if exists, then drop column
            try { $table->dropForeign(['teller_id']); } catch (\Throwable $e) {}
            $table->dropColumn('teller_id');
        }
    });
}

};
