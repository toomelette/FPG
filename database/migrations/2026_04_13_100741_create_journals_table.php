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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('book');
            $table->string('control_no');
            $table->date('date');
            $table->string('counterparty')->nullable();
            $table->string('remarks')->nullable();
            $table->string('bank')->nullable();
            $table->string('check_no')->nullable();
            $table->decimal('check_amount')->nullable();
            $table->timestamps();
        });
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->uuid('journal_uuid');
            $table->string('account_code');
            $table->decimal('debit')->nullable();
            $table->decimal('credit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
        Schema::dropIfExists('journal_entries');

    }
};
