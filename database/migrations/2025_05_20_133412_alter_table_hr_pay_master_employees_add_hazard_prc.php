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
            $table->decimal('hazardprc_gross')->nullable();
            $table->decimal('hazardprc_all_days',5,3)->nullable();
            $table->decimal('hazardprc_eligible_days',5,3)->nullable();
            $table->decimal('hazardprc_ineligible_days',5,3)->nullable();
            $table->decimal('hazardprc_tax_rate')->nullable();
            $table->decimal('hazardprc_tax')->nullable();
            $table->decimal('hazardprc_net_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->dropColumn('hazardprc_ineligible_days','hazardprc_eligible_days','hazardprc_all_days','hazardprc_tax_rate','hazardprc_net_amount','hazardprc_gross','hazardprc_tax');
        });
    }
};
