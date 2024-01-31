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
        Schema::create('acctg_subsidiary_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('seq_no')->nullable();
            $table->string('sa_head1')->nullable();
            $table->string('sa_account_code_header')->nullable();
            $table->string('account_id')->nullable();
            $table->string('sa_account_code')->nullable();
            $table->string('sa_name')->nullable();
            $table->string('sa_address')->nullable();
            $table->integer('sa_terms')->nullable();
            $table->boolean('is_active')->nullable();
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
        Schema::dropIfExists('acctg_subsidiary_accounts');
    }
};
