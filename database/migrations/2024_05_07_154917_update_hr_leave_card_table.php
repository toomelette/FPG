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
        Schema::dropIfExists('hr_leave_card');
        Schema::create('hr_leave_card',function (Blueprint $table){
            $table->id();
            $table->string('slug')->nullable();
            $table->string('employee_slug')->nullable();
            $table->string('leave_card')->nullable();
            $table->date('month')->nullable();
            $table->decimal('credits',10,3)->nullable();
            $table->date('usable_until')->nullable();
            $table->string('remarks')->nullable();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
            $table->timestamps();
        });
        Schema::create('hr_leave_begbal',function (Blueprint $table){
            $table->id();
            $table->string('slug')->nullable();
            $table->string('employee_slug')->nullable();
            $table->decimal('vl',10,3)->nullable();
            $table->decimal('sl',10,3)->nullable();
            $table->date('as_of')->nullable();
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_leave_card');
        Schema::dropIfExists('hr_leave_begbal');
    }
};
