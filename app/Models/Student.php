<?php

namespace Academic\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

    protected $with = ['team'];

    public function user() {
        return $this->belongsTo('Academic\Models\User');
    }

    public function team() {
        return $this->belongsTo('Academic\Models\Team');
    }

    public function activities() {
        return $this->belongsToMany('Academic\Models\Activity')->withPivot('grade', 'done', 'returned');
    }

}
