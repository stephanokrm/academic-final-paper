<?php

namespace Academic;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Session;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $with = ['googleEmail'];
    // protected $with = ['student'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome_completo', 'email', 'matricula', 'usuario'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getUser($registration) {
        return $this->where('matricula', $registration)->first();
    }

    public function getStudentsFromForthYear() {
        return $this->whereBetween('matricula', [2060070, 2060092])->where('matricula', '!=', Session::get('user')->matricula)->get();
    }

    public function getNotAssociatedStudentsFromForthYear($enrollments) {
        return $this->whereBetween('matricula', [2060070, 2060092])->whereNotIn('matricula', $enrollments)->where('matricula', '!=', Session::get('user')->matricula)->get();
    }

    public function googleEmail() {
        return $this->hasOne('Academic\GoogleEmail');
    }

    public function student() {
        return $this->hasOne('Academic\Student', 'id_aluno', 'id_usuario');
    }

}
