<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $fillable = ['role'];

    public function users() {
        return $this->belongsToMany('Academic\User');
    }

}
