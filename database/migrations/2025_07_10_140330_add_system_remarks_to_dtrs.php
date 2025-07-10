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
        Schema::table('hr_daily_time_records', function (Blueprint $table) {
            $table->string('system_remarks')->nullable();
        });
        Schema::table('hr_dtr', function (Blueprint $table) {
            $table->string('system_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_daily_time_records', function (Blueprint $table) {
            $table->dropColumn('system_remarks');
        });
        Schema::table('hr_dtr', function (Blueprint $table) {
            $table->dropColumn('system_remarks');
        });
    }
};
