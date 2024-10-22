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
        Schema::table('su_menus', function (Blueprint $table) {
            $table->tinyInteger('vis')->default(1);
            $table->tinyInteger('lm')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('su_menus', function (Blueprint $table) {
            $table->dropColumns('vis','lm');
        });
    }
};
