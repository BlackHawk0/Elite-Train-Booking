<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $fillable = ['name', 'train_type_id', 'capacity'];

    public function train_type()
    {
        return $this->belongsTo('App\TrainType');
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }

}
