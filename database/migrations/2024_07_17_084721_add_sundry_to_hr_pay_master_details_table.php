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
        Schema::table('hr_pay_master_details', function (Blueprint $table) {
            $table->boolean('sundry_account')->nullable();
            $table->string('account_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master_details', function (Blueprint $table) {
            $table->dropColumn('sundry_account','account_code');
        });
    }
};
