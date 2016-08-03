<?php

namespace Academic\Http\Controllers;

use Academic\Services\GoogleService;
use Academic\Services\CalendarService;
use Academic\Http\Controllers\Controller;
use Academic\Calendar;
use Academic\Google;
use Academic\Student;
//
use Illuminate\Http\Request;
//
use Crypt;
//
use Google_Service_Calendar;

class CalendarController extends Controller {

    private $calendarService;

    public function __construct() {
        $service = new GoogleService();
        $client = $service->getClient();
        $this->calendarService = new Google_Service_Calendar($client);
    }

    public function index() {
        $service = new CalendarService($this->calendarService);
        $googleCalendars = $service->listCalendars();
        return view('calendars.index')->withCalendars($googleCalendars);
    }

    public function create() {
        $student = new Student();
        $students = $student->getStudentsByTeamExceptLoggedStudent();
        return view('calendars.create')->withStudents($students);
    }

    public function store(Request $request) {
        $service = new CalendarService($this->calendarService);
        $service->insertCalendar($request);
        return redirect()
                        ->route('calendars.index')
                        ->withMessage('Calendário criado com sucesso.');
    }

    public function edit($id) {
        $calendarId = Crypt::decrypt($id);

        $calendar = new Calendar();
        $calendar = $calendar->getCalendar($calendarId);
        $associated = $calendar->emails;
        $associatedEmails = $calendar->getAssociatedEmails();

        $email = new Google();
        $disassociated = $email->getDisassociated($associatedEmails);

        $service = new CalendarService($this->calendarService);
        $googleCalendar = $service->getCalendar($calendarId);
        return view('calendars.edit')
                        ->withCalendar($googleCalendar)
                        ->withAssociated($associated)
                        ->withDisassociated($disassociated);
    }

    public function update(Request $request, $id) {
        $calendarId = Crypt::decrypt($id);
        $service = new CalendarService($this->calendarService);
        $service->updateCalendar($request, $calendarId);
        return redirect()
                        ->route('calendars.index')
                        ->withMessage('Calendário editado com sucesso.');
    }

    public function destroy(Request $request) {
        $service = new CalendarService($this->calendarService);
        $service->deleteCalendar($request);
        return redirect()
                        ->route('calendars.index')
                        ->withMessage('Calendário excluído com sucesso.');
    }

}
