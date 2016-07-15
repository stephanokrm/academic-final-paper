<?php

namespace Academic\Http\Controllers;

use Academic\Services\GoogleService;
use Academic\Services\CalendarService;
use Academic\Http\Controllers\Controller;
use Academic\User;
//
use Illuminate\Http\Request;
use Crypt;
use Session;
//
use Google_Service_Calendar;

class CalendarController extends Controller {

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
    public function index() {
        $calendars = $this->calendarService->calendarList->listCalendarList();
        return view('calendars.index')->withCalendars($calendars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $students = Session::get('user')->student->team->students;

        $students = $students->filter(function($student) {
            if ($student->user_id != Session::get('user')->id) {
                return $student;
            }
        });

        return view('calendars.create')->withStudents($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $service = new CalendarService($this->calendarService);
        $service->insertCalendar($request);
        return redirect()
                        ->route('calendars.index')
                        ->withMessage('Calendário criado com sucesso.');
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
        $calendarId = Crypt::decrypt($id);
        $service = new CalendarService($this->calendarService);
        $calendar = $service->getCalendar($calendarId);
        $associated = $service->listAssociatedStudentsByAcl($calendarId);
        $students = $service->getNotAssociatedStudentsFromForthYear();
        return view('calendars.edit')
                        ->withCalendar($calendar)
                        ->withAssociated($associated)
                        ->withStudents($students);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $calendarId = Crypt::decrypt($id);
        $service = new CalendarService($this->calendarService);
        $service->updateCalendar($request, $calendarId);
        return redirect()
                        ->route('calendars.index')
                        ->withMessage('Calendário editado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    // public function destroy($id) {
    //     $calendarId = Crypt::decrypt($id);
    //     $service = new CalendarService($this->calendarService);
    //     $service->deleteCalendar($calendarId);
    //     return redirect()
    //                     ->route('calendars.index')
    //                     ->withMessage('Calendário excluído com sucesso.');
    // }

    public function destroy(Request $request) {
        $service = new CalendarService($this->calendarService);
        $service->deleteCalendar($request);
        return redirect()
                        ->route('calendars.index')
                        ->withMessage('Calendário excluído com sucesso.');
    }

}
