<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;
use Session;

class Email extends Model {

    protected $fillable = ['email'];

    public function user() {
        return $this->belongsTo('Academic\User');
    }

    public function calendars() {
        return $this->belongsToMany('Academic\Calendar');
    }

    public function getEmails($emails) {
        return $this->whereIn('email', $emails)->get();
    }

    public function getDisassociated($emails) {
        $teamId = Session::get('user')->student->team_id;
        $userEmail = Session::get('user')->emailGoogle->email;
        return $this->whereNotIn('emails.email', $emails)
                        ->where('emails.email', '!=', $userEmail)
                        ->where('students.team_id', $teamId)
                        ->join('users', 'users.id', '=', 'emails.user_id')
                        ->join('students', 'students.user_id', '=', 'users.id')
                        ->select('emails.email', 'users.name', 'users.registration')
                        ->get();
    }

}
