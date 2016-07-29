<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $fillable = ['weight', 'total_score'];
    protected $with = ['event'];

    public function event() {
        return $this->belongsTo('Academic\Event');
    }

    public function team() {
        return $this->belongsTo('Academic\Team');
    }

    public function students() {
        return $this->belongsToMany('Academic\Student')->withPivot('grade', 'done', 'returned');
    }

}
