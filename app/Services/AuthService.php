<?php

namespace Academic\Services;

use Illuminate\Http\Request;
//
use Auth;
use Exception;
use Session;
//
use Academic\User;

class AuthService {

    public function login(Request $request) {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $registration = Auth::user()->getUsername();
            $this->getUserFromDataBase($registration);
        } else {
            throw new Exception('Essas credenciais não correspondem aos nossos registros.');
        }
    }

    public function logout() {
        Session::forget('user');
    }

    private function getUserFromDataBase($registration) {
        $user = new User();
        $user = $user->getUser($registration);
        Session::put('user', $user);
    }

}
