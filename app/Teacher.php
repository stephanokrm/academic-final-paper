<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {

    public function user() {
        return $this->belongsTo('Academic\Models\User');
    }

}
