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
        Schema::create('hr_pay_template_incentives', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no')->nullable();
            $table->string('incentive_code')->nullable();
            $table->integer('taxable')->nullable();
            $table->integer('priority')->nullable();
            $table->decimal('amount',20,2)->nullable();
            $table->decimal('taxable_amount',20,2)->nullable();
            $table->boolean('non_deletable')->nullable();
        });
        Schema::create('hr_pay_template_deductions', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no')->nullable();
            $table->string('deduction_code')->nullable();
            $table->integer('priority')->nullable();
            $table->decimal('amount',20,2)->nullable();
            $table->decimal('govt_share',20,2)->nullable();
            $table->decimal('ec_share',20,2)->nullable();
            $table->decimal('amount_orig',20,2)->nullable();
            $table->date('effectivity_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_pay_template_incentives');
        Schema::dropIfExists('hr_pay_template_deductions');
    }
};
