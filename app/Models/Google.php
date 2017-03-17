<?php

namespace Academic\Models;

use Illuminate\Database\Eloquent\Model;

use Session;

class Google extends Model {

    protected $fillable = ['email', 'profile_image', 'access_token'];
    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('Academic\Models\User');
    }

    public function scopeEmail($query, $email) {
        return $query->where('email', $email)->first();
    }

    public function scopeEmails($query, $emails) {
        return $query->whereIn('email', $emails)->get();
    }

    public function scopeEmailsByTeam($query, $id) {
        return $query->where('teams.id', $id)
                        ->join('users', 'users.id', '=', 'googles.user_id')
                        ->join('students', 'students.user_id', '=', 'users.id')
                        ->join('teams', 'teams.id', '=', 'students.team_id')
                        ->select('googles.email')
                        ->get()
                        ->lists('email');
    }

    public function scopeGooglesCalendarsExceptCreator($query, $userGoogleId, $calendarId) {
        return $query->where('googles.id', '!=', $userGoogleId)
                        ->where('calendar_google.calendar_id', $calendarId)
                        ->join('calendar_google', 'calendar_google.google_id', '=', 'googles.id')
                        ->get();
    }

    public function scopeDisassociated($query, $emails) {
        $teamId = Session::get('user')->student()->first()->team_id;
        $userEmail = Session::get('user')->google->email;
        return $this->whereNotIn('googles.email', $emails)
                        ->where('googles.email', '!=', $userEmail)
                        ->where('students.team_id', $teamId)
                        ->join('users', 'users.id', '=', 'googles.user_id')
                        ->join('students', 'students.user_id', '=', 'users.id')
                        ->select('googles.email', 'users.name', 'users.registration', 'googles.profile_image')
                        ->get();
    }

}
