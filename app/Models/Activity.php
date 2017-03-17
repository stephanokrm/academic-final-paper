<?php

namespace Academic\Models;

use Illuminate\Database\Eloquent\Model;
use Session;

class Activity extends Model {

    protected $fillable = ['weight', 'total_score'];
    protected $with = ['students'];

    public function event() {
        return $this->belongsTo('Academic\Models\Event');
    }

    public function team() {
        return $this->belongsTo('Academic\Models\Team');
    }

    public function students() {
        return $this->belongsToMany('Academic\Models\Student')->withPivot('grade', 'done', 'returned');
    }

    public function scopeByTeam($query, $id) {
        $user = Session::get('user');
        $teamId = $user->isTeacher() ? $id : $user->student()->first()->team_id;
        return $query->where('team_id', $teamId)->get();
    }

}
