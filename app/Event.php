<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $fillable = ['event'];

    public function calendar() {
        return $this->belongsTo('Academic\Calendar');
    }

}
