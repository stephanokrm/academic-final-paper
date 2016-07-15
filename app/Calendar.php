<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model {

    protected $fillable = ['calendar'];
    protected $with = ['emails'];

    public function emails() {
        return $this->belongsToMany('Academic\Email');
    }

    public function events() {
        return $this->hasMany('Academic\Event');
    }

    public function getCalendar($id) {
        return $this->where('calendar', $id)->first();
    }

}
