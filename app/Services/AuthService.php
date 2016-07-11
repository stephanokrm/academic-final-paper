<?php

namespace Academic\Services;

use Illuminate\Http\Request;
//
use Auth;
use Academic\Exceptions\FormValidationException;
use Session;
//
use Academic\User;

class AuthService {

    public function login(Request $request) {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $this->verifyTypeOfUser($request);
        } else {
            throw new FormValidationException(['username' => 'Essas credenciais não correspondem aos nossos registros.']);
        }
    }

    public function logout() {
        Session::forget('user');
    }

    private function verifyTypeOfUser(Request $request) {
        if (preg_match('#[0-9]#', $request->username)) { 
            $registration = Auth::user()->getUsername();
            $this->getUserFromDataBase($registration);
        } else { 
            $this->getUserFromAD(Auth::user());
        }  
    }

    private function getUserFromDataBase($registration) {
        $user = new User();
        $user = $user->getUser($registration);
        Session::put('user', $user);
    }

    private function getUserFromAD($user) {
        $user = new User();
        $user->nome_completo = $user->getFirstname() . ' ' . $user->getLastname();
        $user->matricula = $user->getUsername();
        $user->email = $user->getEmail();
        Session::put('user', $user);
    }

}
