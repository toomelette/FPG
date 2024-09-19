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
        Schema::create('su_active_ip_address', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('octet1')->nullable();
            $table->string('octet2')->nullable();
            $table->string('octet3')->nullable();
            $table->string('octet4')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('su_active_ip_address');
    }
};
