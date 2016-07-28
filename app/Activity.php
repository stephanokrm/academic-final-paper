<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $fillable = ['weight', 'total_score'];

    public function event() {
        return $this->belongsTo('Academic\Event');
    }
    
    public function team() {
        return $this->belongsTo('Academic\Team');
    }

}
