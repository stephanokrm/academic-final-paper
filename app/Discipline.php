<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model {

    protected $fillable = ['name'];

    public function teams() {
        return $this->belongsToMany('Academic\Team');
    }

    public function teachers() {
        return $this->belongsToMany('Academic\Teacher');
    }

}
