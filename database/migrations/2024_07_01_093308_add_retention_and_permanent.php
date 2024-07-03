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
        Schema::table('rec_document_folders', function (Blueprint $table) {
            $table->integer('retention_period')->nullable();
            $table->boolean('is_permanent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rec_document_folders', function (Blueprint $table) {
            $table->dropColumn('retention_period','is_permanent');
        });
    }
};
