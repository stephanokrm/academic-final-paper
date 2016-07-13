<?php namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Email extends Model {

	protected $fillable = ['email'];

	public function user() {
		return $this->belongsTo('Academic\User');
	}

}
