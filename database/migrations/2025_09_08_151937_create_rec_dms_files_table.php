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
        Schema::create('rec_dms_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('document_slug')->nullable(true);
            $table->string('file_name')->nullable(true);
            $table->timestamps();
            $table->string('user_created')->nullable(true);
            $table->string('user_updated')->nullable(true);
            $table->string('ip_created')->nullable(true);
            $table->string('ip_updated')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rec_dms_files');
    }
};
