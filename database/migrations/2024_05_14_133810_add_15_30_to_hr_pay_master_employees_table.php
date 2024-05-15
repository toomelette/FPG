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
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->decimal('pay15',20,2)->nullable();
            $table->decimal('pay30',20,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_pay_master_employees', function (Blueprint $table) {
            $table->dropColumn('pay15','pay30');
        });
    }
};
