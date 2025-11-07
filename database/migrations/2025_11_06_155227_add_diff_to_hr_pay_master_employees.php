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
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->decimal('diff_old_monthly_basic',10)->nullable();
            $table->decimal('diff_new_monthly_basic',10)->nullable();
            $table->date('diff_from')->nullable();
            $table->date('diff_to')->nullable();
            $table->decimal('diff_days')->nullable();
            $table->decimal('diff_gross')->nullable();
            $table->decimal('diff_net')->nullable();
            $table->json('diff_other')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->dropColumn([
                'diff_old_monthly_basic',
                'diff_new_monthly_basic',
                'diff_from',
                'diff_to',
                'diff_days',
                'diff_gross',
                'diff_net',
                'diff_other',
            ]);
        });
    }
};
