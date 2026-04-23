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
        Schema::create('inventory_transfers', function (Blueprint $table) {
            $table->id();
            $table->uuid('project_uuid');
            $table->uuid();
            $table->string('control_no')->nullable();
            $table->date('date')->nullable();
            $table->string('transfer_to')->nullable();
            $table->string('remarks')->nullable();
            $table->decimal('total_amount_due',10)->nullable();

            $table->string('user_created')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_updated')->nullable();
            $table->timestamps();
        });
        Schema::create('inventory_transfer_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('inventory_transfer_uuid');
            $table->string('stock_uuid')->nullable();
            $table->string('description')->nullable();
            $table->float('qty')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('unit_cost',9)->nullable();
            $table->decimal('amount',9)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transfers');
        Schema::dropIfExists('inventory_transfer_details');
    }
};
