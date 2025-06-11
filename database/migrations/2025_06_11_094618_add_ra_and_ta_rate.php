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
        Schema::table('hr_pay_employee_settings', function (Blueprint $table) {
            $table->decimal('ra_rate')->after('receives_ra')->nullable();
            $table->decimal('ta_rate')->after('receives_ta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_employee_settings', function (Blueprint $table) {
            $table->dropColumn('ra_rate','ta_rate');
        });
    }
};
