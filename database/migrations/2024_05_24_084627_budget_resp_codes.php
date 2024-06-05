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
        Schema::table('budget_resp_codes',function (Blueprint $table){
            $table->integer('payroll_vis')->nullable();
            $table->integer('payroll_lm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_resp_codes',function (Blueprint $table){
            $table->dropColumn('payroll_vis', 'payroll_lm');
        });
    }
};
