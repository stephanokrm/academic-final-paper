<?php

namespace Academic\Http\Controllers;

use Academic\Services\GoogleService;
use Academic\Services\CalendarService;
use Academic\Domain\Color\ColorHelper;
use Academic\Http\Controllers\Controller;
use Academic\Calendar;
use Academic\Google;
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
        $colors = $this->calendarService->colors->get();
        $colorHelper = new ColorHelper();
        $calendars = $service->index();
        return view('calendars.index')->withCalendars($calendars)->withColors($colors)->withColorHelper($colorHelper);
    }

    public function create() {
        $service = new CalendarService($this->calendarService);
        $dados = $service->create();
        return view('calendars.create')->withDados($dados);
    }

    public function store(Request $request) {
        $service = new CalendarService($this->calendarService);
        $service->store($request);
        return redirect()
                        ->route('calendars.index')
                        ->withMessage('Calendário criado com sucesso.');
    }

    public function edit($id) {
        $calendarId = Crypt::decrypt($id);

        $calendar = new Calendar();
        $calendar = $calendar->getCalendar($calendarId);
        $associated = $calendar->googles;
        $associatedEmails = $calendar->getAssociatedEmails();

        $google = new Google();
        $disassociated = $google->getDisassociated($associatedEmails);

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

    public function destroy($id) {
        $service = new CalendarService($this->calendarService);
        $service->destroy($id);
        return redirect()
                        ->route('calendars.index')
                        ->withMessage('Calendário excluído com sucesso.');
    }

}
