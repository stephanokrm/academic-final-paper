<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;
use Session;

class Team extends Model {

    protected $fillable = ['year', 'description', 'school_year'];
    protected $with = ['course'];

    public function course() {
        return $this->belongsTo('Academic\Models\Course');
    }

    public function activities() {
        return $this->hasMany('Academic\Models\Activity');
    }

    public function calendars() {
        return $this->hasMany('Academic\Models\Calendar');
    }

    public function teachers() {
        return $this->belongsToMany('Academic\Models\Teacher');
    }

    public function disciplines() {
        return $this->belongsToMany('Academic\Models\Discipline');
    }

    public function students() {
        return $this->hasMany('Academic\Models\Student');
    }

    public function scopeYear($query) {
        return $query->where('school_year', date('Y'))->get();
    }

    public function scopeTeacher($query) {
        return $query->where('discipline_teacher_team.teacher_id', Session::get('user')->teacher->id)
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
