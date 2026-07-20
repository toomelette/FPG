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
        Schema::table('petty_cash_liquidations', function (Blueprint $table) {
            $table->string('cv_no')->nullable();
            $table->decimal('approved_amount',12,2)->nullable();
            $table->string('user_action')->nullable();
            $table->timestamp('action_at')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petty_cash_liquidations', function (Blueprint $table) {
            $table->dropColumn(['cv_no','approved_amount','user_action','action_at','status']);
        });
    }
};
