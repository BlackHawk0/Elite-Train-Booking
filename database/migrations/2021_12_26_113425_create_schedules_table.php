<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('train_id');
            $table->unsignedBigInteger('from_id');
            $table->unsignedBigInteger('to_id');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->integer('cost');
            $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
            $table->foreign('from_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('to_id')->references('id')->on('stations')->onDelete('cascade');
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
        Schema::dropIfExists('schedules');
    }
}
