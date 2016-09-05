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

    public static function getTeamsFromTeacher() {
        $user = Session::get('user');
        $team = new Team();
        return $team->where('discipline_teacher_team.teacher_id', $user->teacher->id)
                        ->join('discipline_teacher_team', 'discipline_teacher_team.team_id', '=', 'teams.id')
                        ->join('disciplines', 'disciplines.id', '=', 'discipline_teacher_team.discipline_id')
                        ->join('courses', 'courses.id', '=', 'teams.course_id')
                        ->orderBy('teams.year', 'asc')
                        ->orderBy('teams.school_year', 'asc')
                        ->select('teams.id', 'teams.description', 'teams.school_year', 'teams.year', 'disciplines.name AS discipline', 'courses.name', 'courses.abbreviation')
                        ->get();
    }

    public function getTeamsFromTeacherIds($id) {
        return $this->where('discipline_teacher_team.teacher_id', $id)
                        ->join('discipline_teacher_team', 'discipline_teacher_team.team_id', '=', 'teams.id')
                        ->join('disciplines', 'disciplines.id', '=', 'discipline_teacher_team.discipline_id')
                        ->select('teams.id')
                        ->groupBy('teams.id')
                        ->get()->lists('id');
    }

}
