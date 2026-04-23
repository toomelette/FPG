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
        Schema::create('receiving_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('control_no');
            $table->date('date')->nullable();
            $table->string('po_no')->nullable();
            $table->string('terms')->nullable();
            $table->string('supplier')->nullable();
            $table->string('account_no')->nullable();
            $table->string('inv_dr_no')->nullable();
            $table->string('remarks')->nullable();
            $table->decimal('total_amount_due')->nullable();
            $table->decimal('ewt')->nullable();
            $table->decimal('ap')->nullable();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receiving_reports');
    }
};
