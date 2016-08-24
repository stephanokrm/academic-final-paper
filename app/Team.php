<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {

    protected $fillable = ['year', 'description', 'school_year'];

    public function teachers() {
        return $this->belongsToMany('Academic\Teacher');
    }

    public function disciplines() {
        return $this->belongsToMany('Academic\Discipline');
    }

    public function students() {
        return $this->hasMany('Academic\Student');
    }

    public function course() {
        return $this->belongsTo('Academic\Course');
    }

    public function activities() {
        return $this->hasMany('Academic\Activity');
    }

    public function calendars() {
        return $this->hasMany('Academic\Calendar');
    }

}
