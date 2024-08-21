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
        Schema::table('hr_pay_master_employees',function (Blueprint $table){
            $table->json('saved_employee_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master_employees',function (Blueprint $table){
            $table->dropColumn('saved_employee_data');
        });
    }
};
