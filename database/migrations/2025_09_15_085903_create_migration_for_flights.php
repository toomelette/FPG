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
        Schema::create('flights_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->string('employee_slug');
            $table->string('requested_by');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('pap_code')->nullable();

            $table->string('start_airport')->nullable();
            $table->dateTime('departure')->nullable();
            $table->string('departure_flight_no')->nullable();
            $table->string('layover_airport')->nullable();
            $table->string('layover_flight_no')->nullable();
            $table->string('end_airport')->nullable();

            $table->string('return_start_airport')->nullable();
            $table->dateTime('return_departure')->nullable();
            $table->string('return_departure_flight_no')->nullable();
            $table->string('return_layover_airport')->nullable();
            $table->string('return_layover_flight_no')->nullable();
            $table->string('return_end_airport')->nullable();

            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();

        });
        Schema::create('flights_requests_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('request_slug');
            $table->string('passenger_slug');
            $table->string('attachment_type')->nullable();
            $table->string('file_type')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();
            $table->string('user_created')->nullable();
            $table->string('user_updated')->nullable();
            $table->string('ip_created')->nullable();
            $table->string('ip_updated')->nullable();
        });
        Schema::create('flights_requests_passengers', function (Blueprint $table) {
            $table->id();
            $table->string('request_slug');
            $table->string('slug')->unique();
            $table->string('employee_slug');
            $table->string('employee_name');
            $table->date('employee_birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('seat_preference')->nullable();
        });
        Schema::create('flights_airports', function (Blueprint $table) {
            $table->id();
            $table->string('airport_code');
            $table->string('airport_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights_requests');
        Schema::dropIfExists('flights_requests_attachments');
        Schema::dropIfExists('flights_requests_passengers');
        Schema::dropIfExists('flights_airports');
    }
};
