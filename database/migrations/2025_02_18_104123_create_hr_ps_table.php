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
        Schema::create('hr_ps', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('project_id')->nullable();
            $table->integer('ps_frequency')->nullable();
            $table->string('slug')->nullable();
            $table->string('employee_slug')->nullable();
            $table->string('employee_name')->nullable();
            $table->date('date')->nullable();
            $table->string('personal_official')->nullable();
            $table->string('direct_nondirect')->nullable();
            $table->text('purpose')->nullable();
            $table->text('destination')->nullable();
            $table->string('mode_of_transportation')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_position')->nullable();
            $table->date('supervisor_date')->nullable();
            $table->string('batch_id')->nullable();
            $table->dateTime('departure')->nullable();
            $table->dateTime('return')->nullable();
            $table->integer('time_spent')->nullable();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
            $table->string('user_updated_departure')->nullable();
            $table->string('user_updated_return')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_ps');
    }
};
