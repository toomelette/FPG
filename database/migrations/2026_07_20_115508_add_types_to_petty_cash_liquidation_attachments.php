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
        Schema::table('petty_cash_liquidation_attachments', function (Blueprint $table) {
            $table->string('mime_type')->nullable();
            $table->integer('size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petty_cash_liquidation_attachments', function (Blueprint $table) {
            $table->dropColumn(['mime_type','size']);
        });
    }
};
