<?php

namespace Academic\Models;

use Illuminate\Database\Eloquent\Model;
use Session;

class User extends Model {

    protected $with = ['teacher', 'student'];

    public function google() {
        return $this->hasOne('Academic\Models\Google');
    }

    public function student() {
        return $this->hasOne('Academic\Models\Student');
    }

    public function teacher() {
        return $this->hasOne('Academic\Models\Teacher');
    }

    public static function exists($registration) {
        return User::where('registration', $registration)->exists();
    }

    public function isTeacher() {
        return count($this->teacher) > 0;
    }

    public function scopeRegistration($query, $registration) {
        return $query->with('google')->where('registration', '=',$registration)->first();
    }

    public function scopeTeam($query) {
        $user = Session::get('user');
        return $query->where('users.id', '!=', $user->id)
                        ->where('students.team_id', $user->student()->first()->team_id)
                        ->join('students', 'students.user_id', '=', 'users.id')
                        ->join('googles', 'googles.user_id', '=', 'users.id')
                        ->select('users.name', 'googles.email', 'googles.profile_image')
                        ->orderBy('users.name', 'asc')
                        ->groupBy('users.name', 'googles.email', 'googles.profile_image')
                        ->get();
    }

}
