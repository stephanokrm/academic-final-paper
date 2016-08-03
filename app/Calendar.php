<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model {

    protected $fillable = ['calendar'];
    protected $with = ['googles'];

    public function googles() {
        return $this->belongsToMany('Academic\Google');
    }

    public function events() {
        return $this->hasMany('Academic\Event');
    }

    public function getCalendar($id) {
        return $this->where('calendar', $id)->first();
    }

    public function exists($id) {
        return $this->where('calendar', $id)->exists();
    }

    public function getAssociatedEmails() {
        return $this->where('calendars.calendar', '=', $this->calendar)
                        ->join('calendar_email', 'calendar_email.calendar_id', '=', 'calendars.id')
                        ->join('googles', 'googles.id', '=', 'calendar_email.email_id')
                        ->select('googles.email')
                        ->get()
                        ->lists('email');
    }

}
