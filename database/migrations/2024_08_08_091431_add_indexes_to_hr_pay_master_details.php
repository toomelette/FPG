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
            $table->unique(['pay_master_employee_listing_slug','type','code'],'emplist_type_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master_details', function (Blueprint $table) {
            $table->dropUnique('emplist_type_code_unique');
        });
    }
};
