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
        Schema::create('project_preparations', function (Blueprint $table) {
            $table->id();
            $table->uuid('sales_invoice_uuid');
            $table->uuid();
            $table->string('control_no')->nullable();
            $table->date('date')->nullable();
            $table->string('remarks')->nullable();
            $table->string('user_created')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_updated')->nullable();
            $table->timestamps();
            $table->string('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_preparations');
    }
};
