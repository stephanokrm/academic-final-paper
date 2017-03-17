<?php

namespace Academic\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {

    public function user() {
        return $this->belongsTo('Academic\Models\User');
    }

}
