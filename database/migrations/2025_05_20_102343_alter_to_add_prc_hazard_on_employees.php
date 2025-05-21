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
        Schema::create('hr_pay_employee_settings', function (Blueprint $table) {
            $table->id();
            $table->string('employee_slug')->nullable()->unique();
            $table->tinyInteger('receives_ra')->nullable();
            $table->tinyInteger('receives_ta')->nullable();
            $table->tinyInteger('receives_hazard_prc')->nullable();
            $table->float('hazard_prc_tax_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_pay_employee_settings');
    }
};
