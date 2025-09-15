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
        Schema::create('rec_dms_attachment', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('document_note_slug')->nullable(true);
            $table->string('document_attachment_file')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rec_dms_attachment');
    }
};
