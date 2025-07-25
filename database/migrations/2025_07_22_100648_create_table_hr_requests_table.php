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
        Schema::create('hr_requests', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('tracking_no')->unique();
            $table->string('employee_slug')->nullable();
            $table->string('employee_full')->nullable();
            $table->string('document')->nullable();
            $table->string('details')->nullable();
            $table->json('status')->nullable();
            $table->tinyInteger('project_id')->nullable();
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_requests');
    }
};
