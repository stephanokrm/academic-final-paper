<?php

namespace Academic\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $fillable = ['event'];

    public function calendar() {
        return $this->belongsTo('Academic\Models\Calendar');
    }

    public function activities() {
        return $this->hasMany('Academic\Models\Activity');
    }

}
