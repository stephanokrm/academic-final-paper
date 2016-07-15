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
            $registration = Auth::user()->getUsername();
            return $this->getUserFromDataBase($registration);
        } else {
            throw new FormValidationException(['username' => 'Essas credenciais não correspondem aos nossos registros.']);
        }
    }

    public function logout() {
        Session::forget('user');
    }

    private function getUserFromDataBase($registration) {
        $user = new User();
        if ($user->exists($registration)) {
            $user = $user->getUser($registration);
            Session::put('user', $user);
        } else {
            $user->name = Auth::user()->getFirstname() . ' ' . Auth::user()->getLastname();
            $user->registration = $registration;
            $user->email = Auth::user()->getEmail();
            $user->save();
            Session::put('user', $user);
            return $user;
        }
    }

}
