<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPaymentTransaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['merchant_request_id', 'checkout_request_id', 'amount', 'receipt_number', 'transaction_date', 'phone_number'];

    /**
     * Add booking payments to transactions table.
     */
    public function booking_payment()
    {
        return $this->hasOne('App\BookingPayment');
    }

}
