<?php

namespace Academic\Services;

use Auth;
use Session;
use Academic\Models\User;
use Academic\Models\Team;
use Academic\Models\Google;
use Academic\Models\Teacher;
use Academic\Models\Student;
use Academic\Http\Requests\LoginRequest;
use Academic\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exception\HttpResponseException;

class UserService {

    public function logout() {
        Session::forget('user', 'credentials');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  LoginRequest $request
     * @return mixed
     */
    public function authenticate(LoginRequest $request) {
        if (Auth::attempt($request->all())) {
            return $this->searchForUserInDatabase();
        } else {
            $this->failedValidation();
        }

//        if ($request->username == '02060091' && $request->password == 'Fames17016924') {
//            return $this->searchForUserInDatabase();
//        }
    }

    /**
     * Update user in database.
     *
     * @param  \Academic\Http\Requests\RegisterRequest $request     
     * @param  int $id
     * @return \Academic\Models\User
     */
    public function update(RegisterRequest $request, $id) {
        $user = User::findOrFail($id);
        $user->birthday = $request->birthday;
        $user->active = '1';
        $user->save();

        $team = Team::findOrFail($request->team);

        $student = new Student();
        $student->user()->associate($user);
        $student->team()->associate($team);
        $student->save();

        $google = new Google();
        $google->email = $request->email;
        $google->profile_image = '/~academic/images/user.svg';
        $google->user()->associate($user);
        $google->save();

        Session::put('user', $user);
        return $user->where('registration', $user->registration)->with('student', 'google')->first();
    }

    /**
     * Search for user in database.
     *
     * @return \Academic\Models\User
     */
    private function searchForUserInDatabase() {
        $registration = Auth::user()->getUsername();
//        $registration = '02060091';
        if (User::exists($registration)) {
            $user = User::registration($registration);
        } else {
            $user = $this->fillNewUser();
            if ($this->containsNumbers($registration)) {
                $user->active = '0';
                $user->save();
            } else {
                $user->active = '1';
                $user->save();
                $this->registerNewTeacher($user);
            }
        }
        Session::put('user', $user);
        return $user->where('registration', $registration)->with('teacher', 'google')->first();
    }

    /**
     * Fill attributes from new user.
     *
     * @return \Academic\Models\User
     */
    private function fillNewUser() {
        $user = new User();
        $user->name = Auth::user()->getFirstname() . ' ' . Auth::user()->getLastname();
        $user->registration = Auth::user()->getUsername();
        $user->email = Auth::user()->getEmail();
//        $user->name = 'Stephano Ramos Pinto';
//        $user->registration = '02060091';
//        $user->email = 'stephano.ramos.p@gmail.com';
        return $user;
    }

    /**
     * Register new teacher in database.
     *
     */
    private function registerNewTeacher(User $user) {
        $google = new Google();
        $google->email = Auth::user()->getUsername() . '@canoas.ifrs.edu.br';
        $google->profile_image = '/images/user.svg';
        $google->user()->associate($user);
        $google->save();

        $teacher = new Teacher();
        $teacher->user()->associate($user);
        $teacher->save();
    }

    /**
     * Check if string contain numbers.
     *
     * @return bool
     */
    private function containsNumbers($string) {
        return preg_match('/\\d/', $string) > 0;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @return mixed
     */
    private function failedValidation() {
        throw new HttpResponseException(new JsonResponse(['authentication' => 'Essas credenciais não correspondem aos nossos registros.'], 422));
    }

    public function usersByTeam() {
        return User::team();
    }

}
