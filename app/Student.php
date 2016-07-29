<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;
use Session;

class Student extends Model {

    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('Academic\User');
    }

    public function team() {
        return $this->belongsTo('Academic\Team');
    }

    public function activities() {
        return $this->belongsToMany('Academic\Activity')->withPivot('grade', 'done', 'returned');
    }

    public function getStudentsByTeamExceptLoggedStudent() {
        $userId = Session::get('user')->id;
        $teamId = Session::get('user')->student->team_id;
        return $this->where('students.user_id', '!=', $userId)
                        ->where('students.team_id', $teamId)
                        ->get();
    }

}
