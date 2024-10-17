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
        Schema::table('hr_pay_master_details',function (Blueprint $table){
            $table->decimal('non_taxable_amount',10)->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master_details',function (Blueprint $table){
            $table->dropColumn('non_taxable_amount');
        });
    }
};
