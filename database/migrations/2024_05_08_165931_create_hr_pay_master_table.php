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
        Schema::create('hr_pay_master', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->date('date')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
        });
        Schema::create('hr_pay_master_employees',function (Blueprint $table){
            $table->id();
            $table->string('pay_master_slug')->nullable();
            $table->string('employee_slug')->nullable();
        });
        Schema::create('hr_pay_master_details',function (Blueprint $table){
            $table->id();
            $table->string('pay_master_slug')->nullable();
            $table->string('employee_slug')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->string('code')->nullable();
            $table->decimal('amount',20,3)->nullable();
            $table->integer('priority')->nullable();
            $table->string('source')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_pay_master');
        Schema::dropIfExists('hr_pay_master_details');
        Schema::dropIfExists('hr_pay_master_employees');
    }
};
