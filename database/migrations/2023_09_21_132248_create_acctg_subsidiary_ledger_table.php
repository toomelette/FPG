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
        Schema::create('acctg_subsidiary_ledger', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->string('jev_detail_slug')->nullable();
            $table->string('slug')->nullable();
            $table->integer('seq_no')->nullable();
            $table->string('sa_account_code')->nullable();
            $table->decimal('sl_debit',20,2)->nullable();
            $table->decimal('sl_credit',20,2)->nullable();
            $table->string('ref_book')->nullable();
            $table->date('ref_date')->nullable();
            $table->string('ref_jev_no')->nullable();
            $table->boolean('is_corollary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acctg_subsidiary_ledger');
    }
};
