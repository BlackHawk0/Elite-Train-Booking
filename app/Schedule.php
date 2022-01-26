<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['train_id', 'from_id', 'to_id', 'departure_time', 'arrival_time', 'cost'];

    public function train()
    {
        return $this->belongsTo('App\Train');
    }

    public function from()
    {
        return $this->belongsTo('App\Station');
    }

    public function to()
    {
        return $this->belongsTo('App\Station');
    }

}
