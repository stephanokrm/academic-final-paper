<?php

namespace Academic\Http\Controllers;

use Academic\Http\Requests\LoginRequest;
use Academic\Http\Requests\RegisterRequest;
use Academic\Services\UserService;
use Academic\Http\Controllers\Controller;

class UserController extends Controller {

    protected $username = 'username';
    protected $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function usersByTeam() {
        $users = $this->service->usersByTeam();
        return response()->json($users);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  LoginRequest $request
     * @return Response
     */
    public function authenticate(LoginRequest $request) {
        $user = $this->service->authenticate($request);
        return response()->json($user);
    }

    /**
     * Handle an logout attempt.
     */
    public function logout() {
        $this->service->logout();
    }

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
    public function store(RegisterRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
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
    public function update(RegisterRequest $request, $id) {
        $user = $this->service->update($request, $id);
        return response()->json($user);
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
