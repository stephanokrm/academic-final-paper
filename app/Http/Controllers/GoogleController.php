<?php

namespace Academic\Http\Controllers;

use Academic\Services\GoogleService;

class GoogleController extends Controller {

    private $service;

    public function __construct(GoogleService $service) {
        $this->service = $service;
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate() {
        $this->service->authenticate();
        return response()->json(str_random(40));
    }

    /**
     * Create an url for authentication.
     *
     * @return Response
     */
    public function createAuthUrl() {
        $url = $this->service->createAuthUrl();
        return response()->json($url);
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
    public function update($id) {
        //
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
