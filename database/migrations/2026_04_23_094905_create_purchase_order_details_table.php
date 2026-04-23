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
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('purchase_order_uuid');
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
        Schema::dropIfExists('purchase_order_details');
    }
};
