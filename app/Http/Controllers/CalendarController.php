<?php

namespace Academic\Http\Controllers;

use Academic\Services\CalendarService;
use Academic\Http\Requests\CalendarRequest;
use Illuminate\Http\Request;

class CalendarController extends Controller {

    protected $service;

    public function __construct(CalendarService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $calendars = $this->service->index();
        return response()->json($calendars);
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
    public function store(CalendarRequest $request) {
        $calendar = $this->service->store($request);
        return response()->json($calendar);
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
    public function update(CalendarRequest $request, $id) {
        $this->service->update($request, $id);
        return response()->json('Calendário editado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->service->destroy($id);
        return response()->json('Calendário removido!');
    }

    public function attendees($id) {
        $attendees = $this->service->attendees($id);
        return response()->json($attendees);
    }

    public function notAttendees($id) {
        $notAttendees = $this->service->notAttendees($id);
        return response()->json($notAttendees);
    }

    public function addAttendee(Request $request) {
        $this->service->addAttendee($request);
        return response()->json('Aluno adicionado!');
    }

    public function removeAttendee(Request $request) {
        $this->service->removeAttendee($request);
        return response()->json('Aluno removido!');
    }

}
