<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['booking_code', 'departure_time', 'arrival_time', 'travel_date', 'phone', 'passengers', 'fare', 'total_fare', 'payment_status'];
}
