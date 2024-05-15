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
        Schema::table('hr_pay_deductions',function (Blueprint $table){
            $table->string('groupings')->nullable();
            $table->string('factor_operand',3)->nullable();
            $table->float('govt_share_factor')->nullable()->after('factor');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_pay_deductions',function (Blueprint $table){
            $table->dropColumn('groupings','factor_operand','govt_share_factor');
        });
    }
};
