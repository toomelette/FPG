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
        Schema::create('subsidiary_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('parent_account_code');
            $table->string('account_code');
            $table->string('account_title')->nullable();
            $table->string('account_address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('area')->nullable();
            $table->string('business_line')->nullable();
            $table->decimal('credit_limit')->nullable();
            $table->string('tin')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsidiary_accounts');
    }
};
