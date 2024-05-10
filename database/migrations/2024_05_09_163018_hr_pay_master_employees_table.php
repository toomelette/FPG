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
        Schema::table('hr_pay_master_employees',function (Blueprint $table){
            $table->string('slug')->nullable();
        });
        Schema::table('hr_pay_master_details',function (Blueprint $table){
            $table->string('pay_master_employee_listing_slug')->after('pay_master_slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_pay_master_employees',function (Blueprint $table){
            $table->dropColumn('slug');
        });
        Schema::table('hr_pay_master_details',function (Blueprint $table){
            $table->dropColumn('pay_master_employee_listing_slug');
        });
    }
};
