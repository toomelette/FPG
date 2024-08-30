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
        Schema::table('su_biometric_devices', function (Blueprint $table) {
            $table->tinyInteger('last_state')->nullable();
            $table->dateTime('last_state_timestamp')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('su_biometric_devices', function (Blueprint $table) {
            $table->dropColumn(['last_state','last_state_timestamp']);
        });
    }
};
