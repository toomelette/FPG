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
        Schema::table('hr_requests', function (Blueprint $table) {
            $table->tinyInteger('request_file')->nullable();
            $table->string('file_path')->nullable();
            $table->dateTime('file_updated_at')->nullable();
            $table->string('file_user_updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_requests', function (Blueprint $table) {
            $table->dropColumn([
                'request_file',
                'file_path',
                'file_updated_at',
                'file_user_updated',
            ]);
        });
    }
};
