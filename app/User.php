<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class User extends Model {

    protected $fillable = ['name', 'birth_date', 'email', 'registration', 'active'];
    protected $dates = ['birth_date'];

    public function exists($registration) {
        return $this->where('registration', $registration)->exists();
    }

    public function student() {
        return $this->hasOne('Academic\Student');
    }

    public function getUser($registration) {
        return $this->where('registration', $registration)->first();
    }

    public function emailGoogle() {
        return $this->hasOne('Academic\Email');
    }

    public function roles() {
        return $this->belongsToMany('Academic\Role');
    }

    public function age() {
        return $this->birth_date->diffInYears(Carbon::now());
    }

    public function getBirthDate() {
        return $this->birth_date->format('d/m/Y');
    }

    public function setBirthDateAttribute($value) {
        $date = Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['birth_date'] = $date->format('Y-m-d');
    }

    public function hasRole($id) {
        return !$this->roles->filter(function($role) use ($id) {
                    return $role->id == $id;
                })->isEmpty();
    }

    public function getTeamFromUser() {
        return $this->student->team_id;
    }

}
