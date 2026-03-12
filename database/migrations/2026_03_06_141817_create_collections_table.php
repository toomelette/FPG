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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('payment_type')->nullable();
            $table->string('ref_no')->nullable();
            $table->date('date')->nullable();
            $table->string('payor')->nullable();
            $table->string('address')->nullable();
            $table->string('remarks')->nullable();
            $table->decimal('total_check',9)->nullable();
            $table->decimal('total_cash',9)->nullable();
            $table->decimal('total_amount',9)->nullable();
            $table->decimal('cwt',9)->nullable();
            $table->decimal('total_paid',9)->nullable();

            $table->string('user_created')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_updated')->nullable();
            $table->timestamps();
        });

        Schema::create('collection_distributions', function (Blueprint $table) {
            $table->id();
            $table->uuid('collection_uuid');
            $table->string('ref_invoice')->nullable();
            $table->string('invoice_no')->nullable();
            $table->decimal('amount',9)->nullable();
        });

        Schema::create('collection_checks', function (Blueprint $table) {
            $table->id();
            $table->uuid('collection_uuid');
            $table->string('bank')->nullable();
            $table->string('check_no')->nullable();
            $table->decimal('amount',9)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
        Schema::dropIfExists('collection_distributions');
        Schema::dropIfExists('collection_checks');
    }
};
