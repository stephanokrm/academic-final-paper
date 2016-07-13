<?php namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model {
	protected $fillable = ['calendar'];

	public function users() {
        return $this->belongsToMany('Academic\User');
    }

    public function events() {
    	return $this->hasMany('Academic\Event');
    }

}
