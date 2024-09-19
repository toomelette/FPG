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
        Schema::create('rec_document_requests', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('request_no')->nullable();
            $table->string('requesting_party')->nullable();
            $table->text('requested_records')->nullable();
            $table->string('purpose')->nullable();
            $table->dateTime('requested_at')->nullable();
            $table->string('requested_by')->nullable();
            $table->string('requested_by_position')->nullable();
            $table->string('endorsed_by')->nullable();
            $table->string('endorsed_by_position')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_by_position')->nullable();
            $table->string('released_by')->nullable();
            $table->string('released_by_position')->nullable();
            $table->dateTime('released_at')->nullable();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
            $table->string('status')->nullable();
            $table->tinyInteger('project_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rec_document_requests');
    }
};
