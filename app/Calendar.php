<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model {

    protected $fillable = ['calendar'];

    public function googles() {
        return $this->belongsToMany('Academic\Models\Google');
    }

    public function events() {
        return $this->hasMany('Academic\Models\Event');
    }

    public function scopeCalendar($query, $calendar) {
        return $query->where('calendar', $calendar)->first();
    }

    public function getAttendeesEmails() {
        return $this->where('calendars.calendar', '=', $this->calendar)
                        ->join('calendar_google', 'calendar_google.calendar_id', '=', 'calendars.id')
                        ->join('googles', 'googles.id', '=', 'calendar_google.google_id')
                        ->select('googles.email')
                        ->get()
                        ->lists('email');
    }

    public function exists($id) {
        return $this->where('calendar', $id)->exists();
    }

    public function team() {
        return $this->belongsTo('Academic\Models\Team');
    }

    public function getAssociatedEmails() {
        return $this->where('calendars.calendar', '=', $this->calendar)
                        ->join('calendar_google', 'calendar_google.calendar_id', '=', 'calendars.id')
                        ->join('googles', 'googles.id', '=', 'calendar_google.google_id')
                        ->select('googles.email')
                        ->get()
                        ->lists('email');
    }

    public static function getCalendarGoogleIdsFromTeams($ids) {
        return Calendar::whereIn('team_id', $ids)->select('calendars.calendar')->get()->lists('calendar');
    }

    public static function getCalendarsIdsByGoogleId($id) {
        return Calendar::where('calendar_google.google_id', $id)
                        ->join('calendar_google', 'calendar_google.calendar_id', '=', 'calendars.id')
                        ->get()
                        ->lists('calendar');
    }

}
