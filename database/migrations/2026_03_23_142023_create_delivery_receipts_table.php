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
        Schema::create('delivery_receipts', function (Blueprint $table) {
            $table->id();
            $table->uuid('invoice_uuid');
            $table->uuid();
            $table->string('type')->nullable();
            $table->string('control_no')->nullable();
            $table->date('date')->nullable();
            $table->string('terms')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_updated')->nullable();
            $table->string('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_receipts');
    }
};
