<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_request_id');
            $table->string('checkout_request_id');
            $table->string('receipt_number');
            $table->timestamp('transaction_date');
            $table->string('phone_number');
            $table->integer('amount');
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
        Schema::dropIfExists('booking_payment_transactions');
    }
}
