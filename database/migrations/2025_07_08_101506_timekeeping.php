<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hr_timekeeping',function (Blueprint $table){
            $table->id();
            $table->string('slug')->unique();
            $table->string('series')->nullable();
            $table->string('employee_slug')->nullable();
            $table->string('name')->nullable();
            $table->string('resp_center')->nullable();
            $table->string('position')->nullable();
            $table->string('guard_on_duty')->nullable();
            $table->string('authorized_official')->nullable();
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
            $table->string('status')->nullable();
            $table->tinyInteger('project_id')->nullable();
        });
        Schema::create('hr_timekeeping_details',function (Blueprint $table){
            $table->id();
            $table->string('timekeeping_slug');
            $table->string('slug');
            $table->date('date');
            $table->time('am_in')->nullable();
            $table->time('am_out')->nullable();
            $table->time('pm_in')->nullable();
            $table->time('pm_out')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_timekeeping');
        Schema::dropIfExists('hr_timekeeping_details');
    }
};
