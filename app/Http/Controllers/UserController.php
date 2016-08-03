<?php

namespace Academic\Http\Controllers;

use Academic\Http\Controllers\Controller;
use Academic\Google;
use Academic\Team;
use Academic\Student;
use Academic\User;
use Academic\Validations\RegisterValidation;
use Illuminate\Http\Request;
use Session;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $user = User::findOrFail($id);
        return view('users.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $validation = new RegisterValidation();
        $validation->validate($request);

        $user = Session::get('user');
        $user->birth_date = $request->birth_date;
        $user->active = '1';
        $user->save();

        $team = Team::findOrFail($request->team);

        $student = new Student();
        $student->user()->associate($user);
        $student->team()->associate($team);
        $student->save();

        $google = new Google();
        $google->email = $request->email;
        $google->profile_image = '/images/user.svg';
        $google->user()->associate($user);
        $google->save();

        Session::put('user', $user);

        return redirect()->route('home.index')->withMessage('Registro efetuado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
