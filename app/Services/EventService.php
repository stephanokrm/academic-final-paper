<?php

namespace Academic\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
//
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_EventReminders;
//
use Academic\Validations\EventValidation;
use Academic\Models\EventModel;

class EventService {

    private $calendarService;

    public function __construct(Google_Service_Calendar $calendarService) {
        $this->calendarService = $calendarService;
    }

    public function insertEvent(Request $request) {
        $this->validate($request);
        $googleEvent = $this->fillGoogleEvent($request);
        $this->calendarService->events->insert($request->calendar_id, $googleEvent);
    }

    public function updateEvent(Request $request, $calendarId, $eventId) {
        $this->validate($request);
        $googleEvent = $this->getEvent($calendarId, $eventId);
        $googleEvent = $this->fillGoogleEvent($request, $googleEvent);
        $this->calendarService->events->update($calendarId, $googleEvent->getId(), $googleEvent);
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
        $googleEvent = $this->fillGoogleEventDateTime($request, $googleEvent);
        $googleEvent = $this->fillGoogleEventReminders($googleEvent);

        return $googleEvent;
    }

    private function fillGoogleEventDateTime(Request $request, Google_Service_Calendar_Event $googleEvent) {
        $carbon = new Carbon();
        $end = new Google_Service_Calendar_EventDateTime();
        $start = new Google_Service_Calendar_EventDateTime();

        $allDay = $request->all_day;

        $beginDate = $carbon->createFromFormat('d/m/Y', $request->begin_date)->toDateString();
        $endDate = $carbon->createFromFormat('d/m/Y', $request->end_date)->toDateString();

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

    private function fillGoogleEventReminders(Google_Service_Calendar_Event $googleEvent) {

        $eventReminders = new Google_Service_Calendar_EventReminders();
        $eventReminders->setUseDefault(true);
        $googleEvent->setReminders($eventReminders);

        return $googleEvent;
    }

    public function listEvents($idCalendar) {
        $googleEvents = $this->calendarService->events->listEvents($idCalendar);
        $events = [];
        $googleEvents = $googleEvents->getItems();
        if(empty($googleEvents)) {
            return $events;
        } else {
            foreach ($googleEvents as $googleEvent) {
                $events[] = $this->transformGoogleEventToModel($googleEvent);
            }
        }
        return $events;
    }

    public function transformGoogleEventToModel(Google_Service_Calendar_Event $googleEvent) {
        $event = new EventModel();
        $event->setId($googleEvent->getId());
        $event->setSummary($googleEvent->getSummary());
        $event->setDescription($googleEvent->getDescription());
        $event->setIncludeAddress(false);
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

}
