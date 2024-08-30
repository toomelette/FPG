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
        Schema::table('hr_leave_card', function (Blueprint $table) {
            $table->decimal('deduction',8,3)->nullable()->after('credits');
            $table->string('type')->after('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_leave_card', function (Blueprint $table) {
            $table->dropColumn('deduction','type');
        });
    }
};
