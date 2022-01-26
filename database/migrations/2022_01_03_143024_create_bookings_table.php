<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->string('from');
            $table->string('to');
            $table->date('travel_date');
            $table->string('phone')->nullable();
            $table->integer('passengers');
            $table->integer('fare');
            $table->integer('total_fare');
            $table->enum('payment_status', [0, 1])->default(0);
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
        Schema::dropIfExists('bookings');
    }
}
