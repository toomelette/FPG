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
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->dropColumn('rata_actualdays','rata_deduction');
        });
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->decimal('rata_ra_rate')->nullable();
            $table->decimal('rata_ta_rate')->nullable();
            $table->decimal('rata_actual_days_worked',5,3)->nullable();
            $table->decimal('rata_deductions')->nullable();
            $table->decimal('rata_net_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->dropColumn('rata_ta_rate','rata_ra_rate','rata_deductions','rata_net_amount','rata_actual_days_worked');
        });
    }
};
