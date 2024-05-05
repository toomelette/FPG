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
        Schema::table('hr_pay_template_incentives',function (Blueprint $table){
            $table->renameColumn('employee_no','employee_slug');
        });
        Schema::table('hr_pay_template_deductions',function (Blueprint $table){
            $table->renameColumn('employee_no','employee_slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_pay_template_incentives',function (Blueprint $table){
            $table->renameColumn('employee_slug','employee_no');
        });
        Schema::table('hr_pay_template_deductions',function (Blueprint $table){
            $table->renameColumn('employee_slug','employee_no');
        });
    }
};
