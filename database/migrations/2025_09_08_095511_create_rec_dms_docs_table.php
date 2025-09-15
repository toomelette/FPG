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
        Schema::create('rec_dms_docs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->mediumText('document_control_no')->nullable(true);
            $table->mediumText('document_title')->nullable(true);
            $table->dateTime('document_date')->nullable(true);
            $table->string('document_origin')->nullable(true);
            $table->string('document_destination')->nullable(true);
            $table->mediumText('document_file')->nullable(true);
            $table->string('document_status')->nullable(true);
            $table->integer('dissiminate')->nullable(true);
            $table->string('document_view_status')->nullable(true);
            $table->string('document_type')->nullable(true);
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
        Schema::dropIfExists('rec_dms_docs');
    }
};
