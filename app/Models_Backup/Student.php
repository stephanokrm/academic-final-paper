<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;

use Academic\User;

class Student extends Model {

	protected $primaryKey = 'id_aluno';
	protected $table = 'aluno';
	protected $with = ['classe'];

	public function classe() {
		return $this->belongsTo('Academic\Classe', 'id_turma');
	}

	public function user() {
        return User::where('id_usuario', $this->id_aluno)->first();
    }

}
