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
        Schema::create('rbac_evaluation',function (Blueprint $table){
            $table->id();
            $table->string('slug')->nullable();
            $table->string('transaction_slug')->nullable();
            $table->string('concat_items')->nullable();
            $table->decimal('abc')->nullable();
            $table->string('winning_supplier')->nullable();
            $table->string('winning_supplier_slug')->nullable();
            $table->decimal('bid_price')->nullable();
            $table->string('mode_of_procurement')->nullable();
            $table->string('note')->nullable();
            $table->string('justification')->nullable();
            $table->string('recommending_approval')->nullable();
            $table->string('aq_no')->nullable();
        });

        Schema::create('rbac_evaluation_offers',function (Blueprint $table){
            $table->id();
            $table->string('slug')->nullable();
            $table->string('evaluation_slug')->nullable();
            $table->string('supplier')->nullable();
            $table->string('supplier_slug')->nullable();
            $table->string('item')->nullable();
            $table->string('item_slug')->nullable();
            $table->integer('qty')->nullable();
            $table->string('offer')->nullable();
            $table->decimal('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rbac_evaluation');
        Schema::dropIfExists('rbac_evaluation_offers');
    }
};
