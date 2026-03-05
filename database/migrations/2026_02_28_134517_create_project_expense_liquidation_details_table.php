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
        Schema::create('project_expense_liquidation_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('project_expense_liquidation_uuid');
            $table->string('description')->nullable();
            $table->decimal('debit')->nullable();
            $table->decimal('credit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_expense_liquidation_details');
    }
};
