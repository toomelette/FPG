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
        Schema::table('hr_pay_master',function (Blueprint $table){
            $table->integer('is_locked')->nullable();
            $table->string('user_locked')->nullable();
            $table->dateTime('locked_at')->nullable();
            $table->string('user_unlocked')->nullable();
            $table->dateTime('unlocked_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_pay_master',function (Blueprint $table){
            $table->dropColumn('is_locked','user_locked','locked_at','user_unlocked','unlocked_at');
        });
    }
};
