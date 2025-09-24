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
        Schema::table('hr_employee_service_records', function (Blueprint $table) {
            $table->string('item_no')->nullable();
            $table->string('salary_type')->nullable();
            $table->integer('grade')->nullable();
            $table->integer('step')->nullable();
            $table->decimal('monthly_basic')->nullable();
            $table->string('due_to')->nullable();
            $table->string('file_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_employee_service_records', function (Blueprint $table) {
            $table->dropColumn([
                'item_no',
                'due_to',
                'grade',
                'step',
                'monthly_basic',
                'salary_type',
                'file_path'
            ]);
        });
    }
};
