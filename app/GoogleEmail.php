<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class GoogleEmail extends Model {

    protected $fillable = ['email', 'active'];
    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('Academic\User');
    }

}
