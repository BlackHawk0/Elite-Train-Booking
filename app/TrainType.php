<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainType extends Model
{
    protected $fillable = ['type'];

    public function trains()
    {
        return $this->hasMany('App\Train');
    }
}
