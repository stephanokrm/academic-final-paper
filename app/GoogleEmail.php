<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;
use Session;

class GoogleEmail extends Model {

    protected $fillable = ['email', 'active'];
    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('Academic\User');
    }

    public function getNotAssociatedStudentsFromForthYear($enrollments) {
    	return $this->user()->whereBetween('matricula', [2060070, 2060092])->whereNotIn('matricula', $enrollments)->where('matricula', '!=', Session::get('user')->matricula)->get();
    }

}
