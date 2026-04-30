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
        Schema::create('project_expense_liquidation_projects', function (Blueprint $table) {
            $table->id();
            $table->uuid('project_expense_liquidation_uuid');
            $table->uuid('sales_invoice_uuid');
            $table->decimal('amount');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_expense_liquidation_projects');
    }
};
