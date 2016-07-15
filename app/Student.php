<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

    public function user() {
        return $this->belongsTo('Academic\User');
    }

    public function team() {
        return $this->belongsTo('Academic\Team');
    }

}
