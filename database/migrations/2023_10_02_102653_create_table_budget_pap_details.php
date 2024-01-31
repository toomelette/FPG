<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_pap_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string('pap_slug')->nullable();
            $table->string('slug')->nullable();
            $table->decimal('ps',20,2)->nullable();
            $table->decimal('co',20,2)->nullable();
            $table->decimal('mooe',20,2)->nullable();
            $table->string('type')->nullable();
            $table->string('source_slug')->nullable();
            $table->string('destination_slug')->nullable();
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_pap_adjustments');
    }
};
