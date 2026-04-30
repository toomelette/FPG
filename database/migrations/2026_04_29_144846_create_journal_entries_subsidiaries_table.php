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
        Schema::create('journal_entries_subsidiaries', function (Blueprint $table) {
            $table->id();
            $table->uuid('journal_entry_uuid');
            $table->string('account_code');
            $table->decimal('debit');
            $table->decimal('credit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entries_subsidiaries');
    }
};
