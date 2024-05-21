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
        Schema::create('su_resp_center_tree', function (Blueprint $table) {
            $table->id();
            $table->string('rc_code')->nullable();
            $table->string('parent_rc_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.pj
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('su_resp_center_tree');
    }
};
