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
        Schema::create('hr_cos', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();

            $table->string('memo_code')->nullable();
            $table->date('memo_date')->nullable();
            $table->string('funds_available')->nullable();
            $table->string('funds_available_position')->nullable();


            $table->tinyInteger('is_active')->nullable();

            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_updated')->nullable();
        });

        Schema::create('hr_cos_employees', function (Blueprint $table) {
            $table->id();
            $table->string('hr_cos_employees_slug')->unique();
            $table->string('cos_slug');
            $table->string('employee_slug');
            $table->string('employee_fullname')->nullable();
            $table->string('status')->nullable();
            $table->string('evaluation_path')->nullable();
            $table->dateTime('evaluation_uploaded_at')->nullable();
            $table->tinyInteger('has_printed')->nullable();
            $table->json('logs')->nullable();
            $table->json('other_data')->nullable();
            $table->string('resp_center')->nullable();
            $table->string('cos_assignment')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_cos');
        Schema::dropIfExists('hr_cos_employees');
    }
};
