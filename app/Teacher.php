<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {

    public function teams() {
        return $this->belongsToMany('Academic\Team');
    }

    public function disciplines() {
        return $this->belongsToMany('Academic\Discipline');
    }

    public function user() {
        return $this->belongsTo('Academic\User');
    }

}
