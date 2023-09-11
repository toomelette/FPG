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
        Schema::create('acctg_jev', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('slug')->nullable();
            $table->date('date')->nullable();
            $table->string('fund_source')->nullable();
            $table->string('jev_no')->nullable();
            $table->string('ref_book')->nullable();
            $table->date('ref_date')->nullable();
            $table->string('rcd_no')->nullable();
            $table->integer('year_no')->nullable();
            $table->integer('month_no')->nullable();
            $table->integer('seq_no')->nullable();
            $table->text('remarks')->nullable();
            $table->text('remarks2')->nullable();
            $table->text('remarks3')->nullable();
            $table->string('cd_no')->nullable();
            $table->string('payee')->nullable();
            $table->string('check_from')->nullable();
            $table->string('check_to')->nullable();
            $table->string('collecting_officer')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('prepared_by_position')->nullable();
            $table->integer('is_locked')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_by_position')->nullable();
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
        });

        Schema::create('acctg_jev_details',function (Blueprint $table){
            $table->id();
            $table->integer('project_id');
            $table->string('jev_slug');
            $table->string('slug');
            $table->boolean('is_corollary');
            $table->integer('seq_no');
            $table->string('resp_center');
            $table->string('account_code');
            $table->decimal('jev_debit',20,2);
            $table->decimal('jev_credit',20,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acctg_jev');
        Schema::dropIfExists('acctg_jev_details');
    }
};
