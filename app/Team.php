<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;
use Session;

class Team extends Model {

    protected $fillable = ['year', 'description', 'school_year'];
    protected $with = ['course'];

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

    public function getTeamsFromTeacher() {
        $user = Session::get('user');
        $teacherId = $user->teacher->id;
        return $this->where('discipline_teacher_team.teacher_id', $teacherId)
                        ->join('discipline_teacher_team', 'discipline_teacher_team.team_id', '=', 'teams.id')
                        ->orderBy('teams.year', 'asc')
                        ->orderBy('teams.school_year', 'asc')
                        ->get();
    }

}
