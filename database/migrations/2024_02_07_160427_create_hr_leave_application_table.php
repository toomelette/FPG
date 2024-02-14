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
        Schema::dropIfExists('hr_leave_application');
        Schema::create('hr_leave_application', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('leave_application_no')->nullable();
            $table->string('department')->nullable();
            $table->string('employee_slug')->nullable();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('position')->nullable();
            $table->decimal('salary')->nullable();
            $table->date('date_of_filing')->nullable();
            $table->string('leave_type')->nullable();
            $table->string('leave_type_specify')->nullable();
            $table->string('leave_details')->nullable();
            $table->string('leave_specify')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->string('commutation')->nullable();
            $table->string('certified_by')->nullable();
            $table->string('certified_by_position')->nullable();
            $table->string('recommended_by')->nullable();
            $table->string('recommended_by_position')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_by_position')->nullable();
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
        });

        Schema::create('hr_leave_application_dates', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('leave_application_slug')->nullable();
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_leave_application');
    }
};
