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
        Schema::table('hr_pay_master', function (Blueprint $table) {
            $table->string('a_name')->nullable();
            $table->string('a_position')->nullable();
            $table->string('b_name')->nullable();
            $table->string('b_position')->nullable();
            $table->string('c_name')->nullable();
            $table->string('c_position')->nullable();
            $table->string('d_name')->nullable();
            $table->string('d_position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master', function (Blueprint $table) {
            $table->dropColumn([
                'a_name',
                'a_position',
                'b_name',
                'b_position',
                'c_name',
                'c_position',
                'd_name',
                'd_position',
            ]);
        });
    }
};
