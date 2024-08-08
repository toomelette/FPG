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
            $table->decimal('ec_share',12)->nullable()->after('amount');
            $table->decimal('govt_share',12)->nullable()->after('amount');
            $table->date('refund_date')->nullable();
            $table->decimal('refund_amount',12)->nullable();
            $table->string('refund_remarks')->nullable();
            $table->string('refunded_by')->nullable();
            $table->dateTime('refunded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_pay_master_details', function (Blueprint $table) {
            $table->dropColumn([
                'ec_share',
                'govt_share',
                'refund_date',
                'refund_amount',
                'refund_remarks',
                'refunded_by',
                'refunded_at',
            ]);
        });
    }
};
