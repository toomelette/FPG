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
            $table->decimal('rata_actualdays')->nullable();
            $table->decimal('rata_deduction')->nullable();
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
            $table->dropColumn('rata_actualdays','rata_deduction');
        });
    }
};
