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
        Schema::table('hr_pay_incentives',function (Blueprint $table){
            $table->integer('n_is_monthly')->nullable();
            $table->integer('n_priority')->nullable();
            $table->string('groupings')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_pay_incentives',function (Blueprint $table){
            $table->dropColumn('n_is_monthly','n_priority','groupings');
        });
    }
};
