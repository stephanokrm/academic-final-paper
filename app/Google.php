<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;
use Session;

class Google extends Model {

    protected $fillable = ['email', 'profile_image'];

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
        $userEmail = Session::get('user')->google->email;
        return $this->whereNotIn('googles.email', $emails)
                        ->where('googles.email', '!=', $userEmail)
                        ->where('students.team_id', $teamId)
                        ->join('users', 'users.id', '=', 'googles.user_id')
                        ->join('students', 'students.user_id', '=', 'users.id')
                        ->select('googles.email', 'users.name', 'users.registration')
                        ->get();
    }

}
