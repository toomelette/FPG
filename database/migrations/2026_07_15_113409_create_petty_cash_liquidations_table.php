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
        Schema::create('petty_cash_liquidations', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->date('date')->nullable();
            $table->decimal('total_amount',12,2);
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
            $table->string('project_id')->nullable();
        });
        Schema::create('petty_cash_liquidation_attachments', function (Blueprint $table) {
            $table->id();
            $table->uuid('petty_cash_liquidation_uuid');
            $table->string('path')->nullable();
            $table->string('file_type')->nullable();
            $table->string('original_filename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petty_cash_liquidations');
        Schema::dropIfExists('petty_cash_liquidation_attachments');
    }
};
