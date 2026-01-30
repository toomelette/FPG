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
            $table->unique(['employee_no','date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_daily_time_records', function (Blueprint $table) {
            $table->dropUnique(['employee_no','date']);
        });
    }
};
