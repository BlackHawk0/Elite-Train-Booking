<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['booking_id', 'transaction_id', 'checkout_id'];

    /**
     * Add booking payment to booking relation.
     */
    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }

    /**
     * Add booking payments to transactions table.
     */
    public function transaction()
    {
        return $this->belongsTo('App\BookingPaymentTransaction', 'transaction_id');
    }

}
