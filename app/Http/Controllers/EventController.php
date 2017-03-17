<?php

namespace Academic\Http\Controllers;

use Academic\Http\Controllers\Controller;
use Academic\Services\EventService;
use Academic\Http\Requests\EventRequest;
use Illuminate\Http\Request;

class EventController extends Controller {

    protected $service;

    public function __construct(EventService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $events = $this->service->index($request);
        return response()->json($events);
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
    public function store(EventRequest $request) {
        $event = $this->service->store($request);
        return response()->json($event);
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
    public function update(EventRequest $request, $id) {
        $event = $this->service->update($request, $id);
        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id) {
        $this->service->destroy($request, $id);
    }

}
