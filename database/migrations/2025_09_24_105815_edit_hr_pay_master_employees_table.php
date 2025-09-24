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
            $table->renameColumn('rata_deductions','rata_total');
        });
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->decimal('rata_deductions')->nullable()->after('rata_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->dropColumn('rata_deductions');
        });
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->renameColumn('rata_total','rata_deductions');
        });
    }
};
