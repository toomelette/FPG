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
        Schema::table('inventory_ledgers', function (Blueprint $table) {
            $table->string('warehouse')->after('amount');
            $table->integer('direction')->after('movement_type');
            $table->string('uom')->after('qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_ledgers', function (Blueprint $table) {
            $table->dropColumn('uom','direction','warehouse');
        });
    }
};
