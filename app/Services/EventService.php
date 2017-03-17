<?php

namespace Academic\Services;

use Illuminate\Http\Request;
use Academic\Services\GoogleService;
use Academic\Transformers\EventTransformer;
use Academic\Builders\GoogleEventBuilder;

class EventService {

    private $calendarService;

    public function __construct() {
        $googleService = new GoogleService();
        $this->calendarService = $googleService->getCalendarService();
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
        $arrayEvents = [];

        $optParams = [
            'singleEvents' => true,
            'timeMin' => $request->start . 'T00:00:00-00:00',
            'timeMax' => $request->end . 'T00:00:00-00:00'
        ];

        foreach ($request->ids as $id) {
            $eventList = $this->calendarService->events->listEvents($id, $optParams);
            $items = $eventList->getItems();
            if (!empty($items)) {
                $events = EventTransformer::fromGoogleEventsToArray($eventList->getItems(), $id);
                $arrayEvents = array_merge($arrayEvents, $events);
            }
        }
        return $arrayEvents;
    }

    public function store(Request $request) {
        $request->begin_date = substr($request->begin_date, 0, 10);
        $request->end_date = substr($request->end_date, 0, 10);
        $calendarEvent = $this->createEvent($request);
        $insertedCalendarEvent = $this->calendarService->events->insert($request->calendar, $calendarEvent);
        $events = EventTransformer::fromGoogleEventsToArray([$insertedCalendarEvent], $request->calendar);
        return $events[0];
    }

    private function createEvent(Request $request) {
        $googleEventBuilder = new GoogleEventBuilder();
        $googleEventBuilder->create()
                ->addSummary($request->summary)
                ->addDescription($request->description)
                ->addColor($request->color);

        if ($request->all_day) {
            return $googleEventBuilder->addStartDate($request->begin_date)
                            ->addEndDate($request->end_date)
                            ->get();
        }

        return $googleEventBuilder->addStartDateTime($request->begin_date, $request->begin_time)
                        ->addEndDateTime($request->end_date, $request->end_time)
                        ->get();
    }

    public function update(Request $request, $id) {
        $request->begin_date = substr($request->begin_date, 0, 10);
        $request->end_date = substr($request->end_date, 0, 10);
        $calendarEvent = $this->editEvent($request, $id);
        $updatedCalendarEvent = $this->calendarService->events->update($request->calendar, $id, $calendarEvent);
        $events = EventTransformer::fromGoogleEventsToArray([$updatedCalendarEvent], $request->calendar);
        return $events[0];
    }

    private function editEvent(Request $request, $id) {
        $event = $this->calendarService->events->get($request->calendar, $id);
        $googleEventBuilder = new GoogleEventBuilder();
        $googleEventBuilder->edit($event)->addSummary($request->summary)
                ->addDescription($request->description)
                ->addColor($request->color);

        if ($request->all_day) {
            return $googleEventBuilder->addStartDate($request->begin_date)
                            ->addEndDate($request->end_date)
                            ->get();
        }

        return $googleEventBuilder->addStartDateTime($request->begin_date, $request->begin_time)
                        ->addEndDateTime($request->end_date, $request->end_time)
                        ->get();
    }

    public function destroy(Request $request, $id) {
        $this->calendarService->events->delete($request->calendar, $id);
    }

}
