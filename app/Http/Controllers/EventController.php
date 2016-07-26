<?php

namespace Academic\Http\Controllers;

use Crypt;
//
use Illuminate\Http\Request;
//
use Academic\Services\EventService;
use Academic\Services\GoogleService;
use Academic\Http\Controllers\Controller;
//
use Google_Service_Calendar;

class EventController extends Controller {

    private $calendarService;

    public function __construct() {
        $service = new GoogleService();
        $client = $service->getClient();
        $this->calendarService = new Google_Service_Calendar($client);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id) {

        $idCalendar = Crypt::decrypt($id);
        $service = new EventService($this->calendarService);
        $events = $service->listEvents($idCalendar);

        return view('events.index')
                        ->withEvents($events)
                        ->withCalendar($idCalendar);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id) {
        $idCalendar = Crypt::decrypt($id);
        $colors = $this->calendarService->colors->get();
        return view('events.create')
                        ->withCalendar($idCalendar)
                        ->withColors($colors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $service = new EventService($this->calendarService);
        $service->insertEvent($request);
        return redirect()
                        ->route('events.index', Crypt::encrypt($request->calendar_id))
                        ->withMessage('Evento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show() {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($idCalendar, $idEvent) {
        $idCalendar = Crypt::decrypt($idCalendar);
        $service = new EventService($this->calendarService);
        $googleEvent = $service->getEvent($idCalendar, $idEvent);
        $event = $service->transformGoogleEventToModel($googleEvent);
        $colors = $this->calendarService->colors->get();
        return view('events.edit')
                        ->withEvent($event)
                        ->withCalendarId($idCalendar)
                        ->withColors($colors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $idCalendar, $idEvent) {
        $idCalendar = Crypt::decrypt($idCalendar);
        $service = new EventService($this->calendarService);
        $service->updateEvent($request, $idCalendar, $idEvent);
        return redirect()
                        ->route('events.index', Crypt::encrypt($idCalendar))
                        ->withMessage('Evento editado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id) {
        $service = new EventService($this->calendarService);
        $service->deleteEvent($request->calendar_id, $id);
        return redirect()
                        ->route('events.index', Crypt::encrypt($request->calendar_id))
                        ->withMessage('Evento excluído com sucesso.');
    }

}
