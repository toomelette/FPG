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
        Schema::table('rec_document_requests',function (Blueprint $table){
            $table->string('requesting_party_specify')->nullable()->after('requesting_party');
            $table->text('purpose_specify')->nullable()->after('purpose');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rec_document_requests',function (Blueprint $table){
            $table->dropColumn('purpose_specify','requesting_party_specify');
        });
    }
};
