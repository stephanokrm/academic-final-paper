<?php

namespace Academic\Services;

use Illuminate\Http\Request;
//
use Auth;
use Session;
//
use Academic\User;
use Academic\Google;
use Academic\Teacher;
use Academic\Validations\AuthValidation;
use Academic\Exceptions\FormValidationException;

class AuthService {

    public function login(Request $request) {
        $validation = new AuthValidation();
        $validation->validate($request);

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
            if ($user->active == '0') {
                return $user;
            }
        } else {
            $user = $this->registerUserFromAD($user, $registration);
            if ($this->containsNumbers($registration)) {
                $user->active = '0';
                $user->save();
            } else {
                $user->active = '1';
                $user->save();
                $this->registerTeacher($user, $registration);
            }

            Session::put('user', $user);
            return $user;
        }
    }

    private function containsNumbers($string) {
        return preg_match('/\\d/', $string) > 0;
    }

    private function registerUserFromAD(User $user, $registration) {
        $user->name = Auth::user()->getFirstname() . ' ' . Auth::user()->getLastname();
        $user->registration = $registration;
        $user->email = Auth::user()->getEmail();
        return $user;
    }

    private function registerTeacher(User $user, $registration) {
        $google = new Google();
        $google->email = $registration . '@canoas.ifrs.edu.br';
        $google->profile_image = '/images/user.svg';
        $google->user()->associate($user);
        $google->save();

        $teacher = new Teacher();
        $teacher->user()->associate($user);
        $teacher->save();
    }

}
