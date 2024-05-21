<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_pay_template_deductions',function (Blueprint $table){
            $table->unique(['employee_slug','deduction_code']);
        });

        Schema::table('hr_pay_master_employees',function (Blueprint $table){
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_pay_template_deductions',function (Blueprint $table){
            $table->dropUnique(['employee_slug','deduction_code']);
        });

        Schema::table('hr_pay_master_employees',function (Blueprint $table){
            $table->unique('slug');
        });
    }
};
