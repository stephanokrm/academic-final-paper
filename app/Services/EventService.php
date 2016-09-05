<?php

namespace Academic\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
//
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
//
use Academic\Validations\EventValidation;
use Academic\Models\EventModel;
use Crypt;
use Academic\Domain\Events\EventTransformer;

class EventService {

    private $calendarService;

    public function __construct(Google_Service_Calendar $calendarService) {
        $this->calendarService = $calendarService;
    }

    public function insertEvent(Request $request) {
        $this->validate($request);
        $googleEvent = $this->fillGoogleEvent($request);
        return $this->calendarService->events->insert($request->calendar_id, $googleEvent);
    }

    public function updateEvent(Request $request, $calendarId, $eventId) {
        $this->validate($request);
        $googleEvent = $this->getEvent($calendarId, $eventId);
        $googleEventFilled = $this->fillGoogleEvent($request, $googleEvent);
        $this->calendarService->events->update($calendarId, $googleEventFilled->getId(), $googleEventFilled);
    }

    public function deleteEvent($calendarId, $id) {
        $this->calendarService->events->delete($calendarId, $id);
    }

    public function getEvent($idCalendar, $idEvent) {
        return $this->calendarService->events->get($idCalendar, $idEvent);
    }

    private function validate(Request $request) {
        $validation = new EventValidation();
        $validation->validate($request);
    }

    private function fillGoogleEvent(Request $request, Google_Service_Calendar_Event $googleEvent = null) {

        if (is_null($googleEvent)) {
            $googleEvent = new Google_Service_Calendar_Event();
        }

        $googleEvent->setSummary($request->summary);
        $googleEvent->setDescription($request->description);
        $googleEvent->setColorId($request->color);
        $googleEventWithDate = $this->fillGoogleEventDateTime($request, $googleEvent);

        return $googleEventWithDate;
    }

    private function fillGoogleEventDateTime(Request $request, Google_Service_Calendar_Event $googleEvent) {
        $carbon = new Carbon();
        $end = new Google_Service_Calendar_EventDateTime();
        $start = new Google_Service_Calendar_EventDateTime();

        $allDay = $request->all_day;

        $beginDate = $carbon->createFromFormat('d/m/Y', $request->begin_date)->toDateString();
        $endDate = $googleEvent->getId() ? $carbon->createFromFormat('d/m/Y', $request->end_date)->toDateString() : $carbon->createFromFormat('d/m/Y', $request->end_date)->addDay()->toDateString();

        if (isset($allDay)) {
            $start->setDate($beginDate);
            $googleEvent->setStart($start);
            $end->setDate($endDate);
            $googleEvent->setEnd($end);

            return $googleEvent;
        }

        $start->setDateTime($beginDate . 'T' . $request->begin_time . ':00.000-00:00');
        $googleEvent->setStart($start);
        $end->setDateTime($endDate . 'T' . $request->end_time . ':00.000-00:00');
        $googleEvent->setEnd($end);

        return $googleEvent;
    }

    public function transformGoogleEventToModel(Google_Service_Calendar_Event $googleEvent, $idCalendar) {
        $event = new EventModel();
        $event->setCalendar(Crypt::encrypt($idCalendar));
        $event->setId($googleEvent->getId());
        $event->setSummary($googleEvent->getSummary());
        $event->setDescription($googleEvent->getDescription());
        $event->setColorId($googleEvent->getColorId());

        if (isset($googleEvent->getStart()->dateTime)) {
            $event->setAllDay(false);
            $event->setBeginDate($this->convertDate($googleEvent->getStart()->dateTime));
            $event->setBeginTime($this->convertTime($googleEvent->getStart()->dateTime));
            $event->setBeginDateTime($this->convertDateTime($googleEvent->getStart()->dateTime));

            $event->setEndDate($this->convertDate($googleEvent->getEnd()->dateTime));
            $event->setEndTime($this->convertTime($googleEvent->getEnd()->dateTime));
            $event->setEndDateTime($this->convertDateTime($googleEvent->getEnd()->dateTime));

            $event->setOriginalBeginDate($googleEvent->getStart()->dateTime);
            $event->setOriginalEndDate($googleEvent->getEnd()->dateTime);
        } else {
            $event->setAllDay(true);

            $event->setBeginDate($this->convertDate($googleEvent->getStart()->date));
            $event->setBeginTime(null);

            $event->setEndDate($this->convertDate($googleEvent->getEnd()->date));
            $event->setEndTime(null);

            $event->setOriginalBeginDate($googleEvent->getStart()->date);
            $event->setOriginalEndDate($googleEvent->getEnd()->date);
        }
        return $event;
    }

    private function convertDate($date) {
        return date('d/m/Y', strtotime($date));
    }

    private function convertDateTime($date) {
        return date('d/m/Y - H:i', strtotime(str_replace(['T', 'Z'], ' ', $date)));
    }

    private function convertTime($date) {
        return date('H:i', strtotime(str_replace(['T', 'Z'], ' ', $date)));
    }

    public function index(Request $request) {
        $ids = $request->ids;
        if (empty($ids)) {
            return [];
        } else {
            return $this->getAllEventsFromCalendars($request);
        }
    }

    private function getAllEventsFromCalendars(Request $request) {
        $allEvents = [];
        foreach ($request->ids as $id) {
            $eventList = $this->calendarService->events->listEvents($id, ['timeMin' => $request->start . 'T00:00:00-00:00', 'timeMax' => $request->end . 'T00:00:00-00:00']);
            $events = EventTransformer::fromGoogleEventsToArray($eventList->getItems(), $id);
            $arrayEvents = array_merge($allEvents, $events);
        }
        return $arrayEvents;
    }

}
