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
        Schema::create('hr_pay_incentives', function (Blueprint $table) {
            $table->id();
            $table->string('incentive_code')->nullable();
            $table->string('description')->nullable();
            $table->integer('taxable')->nullable();
            $table->integer('priority')->nullable();
            $table->decimal('fixed_values',20,2)->nullable();
            $table->decimal('taxable_amount',20,2)->nullable();
            $table->integer('tax_free_90k')->nullable();
            $table->integer('incentive_count')->nullable();
            $table->boolean('is_visible')->nullable();
            $table->boolean('non_deletable')->nullable();
            $table->boolean('is_monthly')->nullable();
            $table->timestamps();
        });

        Schema::create('hr_pay_deductions', function (Blueprint $table) {
            $table->id();
            $table->string('deduction_code')->nullable();
            $table->string('description')->nullable();
            $table->integer('taxable')->nullable();
            $table->integer('priority')->nullable();
            $table->float('factor')->nullable();
            $table->string('account_code')->nullable();
            $table->integer('sundry_account')->nullable();
            $table->integer('availables')->nullable();
            $table->string('employee_type')->nullable();
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
        Schema::dropIfExists('hr_pay_incentives');
        Schema::dropIfExists('hr_pay_deductions');
    }
};
