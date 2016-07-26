<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $fillable = ['title', 'weight', 'total_score', 'date'];

    public function event() {
        return $this->belongsTo('Academic\Event');
    }

}
