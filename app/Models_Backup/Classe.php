<?php 

namespace Academic;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model {

	protected $primaryKey = 'id_turma';
	protected $table = 'turma';
	protected $with = ['students'];

	public function students() {
		return $this->hasMany('Academic\Student', 'id_turma');
	}

}
