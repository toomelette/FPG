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
        Schema::create('hr_leave', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->date('date')->nullable();
            $table->string('type')->nullable();
            $table->decimal('add')->nullable();
            $table->decimal('sub')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('hr_leave');
    }
};
