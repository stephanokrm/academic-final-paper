<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

    protected $fillable = ['name', 'abbreviation'];

    public function teams() {
        return $this->hasMany('Academic\Team');
    }

}
