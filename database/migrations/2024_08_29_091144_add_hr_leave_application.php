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
        Schema::table('hr_leave_application', function (Blueprint $table) {
            $table->decimal('actual_deduction',8,3)->nullable()->after('charge_to');
            $table->dateTime('received_at')->nullable();
            $table->string('user_received')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_leave_application', function (Blueprint $table) {
            $table->dropColumn('actual_deduction','received_at','user_received','status');
        });
    }
};
