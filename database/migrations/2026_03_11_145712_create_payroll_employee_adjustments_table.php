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
        Schema::create('payroll_employee_adjustments', function (Blueprint $table) {
            $table->id();
            $table->integer('payroll_employee_id');
            $table->string('employee_uuid');
            $table->string('type')->nullable();
            $table->string('code')->nullable();
            $table->decimal('amount')->nullable();
            $table->decimal('employee_share')->nullable();
            $table->integer('priority')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_employee_adjustments');
    }
};
