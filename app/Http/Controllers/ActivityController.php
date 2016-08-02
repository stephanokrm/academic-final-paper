<?php

namespace Academic\Http\Controllers;

use Academic\Http\Controllers\Controller;
use Academic\Services\AcitivityService;
use Academic\Services\CalendarService;
use Academic\Services\GoogleService;
use Academic\Services\EventService;
use Academic\Validations\ActivityValidation;
use Academic\Calendar;
use Academic\Activity;
use Academic\Event;
use Academic\Team;
use Academic\Models\ActivityModel;
//
use Illuminate\Http\Request;
//
use Google_Service_Calendar;

class ActivityController extends Controller {

    private $calendarService;

    public function __construct() {
        $service = new GoogleService();
        $client = $service->getClient();
        $this->calendarService = new Google_Service_Calendar($client);
    }

    public function index($id) {
        $eventService = new EventService($this->calendarService);
        $service = new AcitivityService();
        $activities = $service->getActivitiesFromTeam($id);
        $activitiesModel = [];
        foreach ($activities as $activity) {
            $calendarId = $activity->event->calendar->calendar;
            $eventId = $activity->event->event;
            $googleEvent = $eventService->getEvent($calendarId, $eventId);
            $event = $eventService->transformGoogleEventToModel($googleEvent);

            $activityModel = new ActivityModel();
            $activityModel->setId($activity->id);
            $activityModel->setSummary($event->getSummary());
            $activityModel->setDate($event->getBeginDate());
            $activityModel->setColorId($event->getColorId());
            $activityModel->setWeight($activity->weight);
            $activityModel->setTotalScore($activity->total_score);
            $activitiesModel[] = $activityModel;
        }

        return view('activities.index')->withActivities($activitiesModel);
    }

    public function create() {
        $service = new CalendarService($this->calendarService);
        $googleCalendars = $service->listCalendars();
        $colors = $this->calendarService->colors->get();
        return view('activities.create')
                        ->withCalendars($googleCalendars)
                        ->withColors($colors);
    }

    public function store(Request $request, $teamId) {
        $validation = new ActivityValidation();
        $validation->validate($request);

        $request->merge(['all_day' => 'Y', 'begin_date' => $request->date, 'end_date' => $request->date]);
        $service = new EventService($this->calendarService);
        $insertedEvent = $service->insertEvent($request);

        $team = Team::findOrFail($teamId);
        $students = $team->students;

        $calendar = new Calendar();
        $calendar = $calendar->getCalendar($request->calendar_id);

        $event = new Event();
        $event->event = $insertedEvent->getId();
        $event->calendar()->associate($calendar);
        $event->save();

        $acitivity = new Activity();
        $acitivity->fill($request->all());
        $acitivity->event()->associate($event);
        $acitivity->team()->associate($team);
        $acitivity->save();

        foreach ($students as $student) {
            $acitivity->students()->attach($student->id, ['done' => '0', 'returned' => '0']);
        }

        return redirect()
                        ->route('activities.index', $teamId)
                        ->withMessage('Atividade criada com sucesso.');
    }

    public function show($id) {
        
    }

    public function edit($id) {
        $eventService = new EventService($this->calendarService);
        $service = new AcitivityService();
        $activity = Activity::findOrFail($id);

        $calendarId = $activity->event->calendar->calendar;
        $eventId = $activity->event->event;
        $googleEvent = $eventService->getEvent($calendarId, $eventId);
        $event = $eventService->transformGoogleEventToModel($googleEvent);

        $activityModel = new ActivityModel();
        $activityModel->setId($activity->id);
        $activityModel->setSummary($event->getSummary());
        $activityModel->setDate($event->getBeginDate());
        $activityModel->setColorId($event->getColorId());
        $activityModel->setDescription($event->getDescription());
        $activityModel->setWeight($activity->weight);
        $activityModel->setTotalScore($activity->total_score);
        $activityModel->setCalendarId($calendarId);

        $service = new CalendarService($this->calendarService);
        $googleCalendars = $service->listCalendars();
        $colors = $this->calendarService->colors->get();

        return view('activities.edit')
                        ->withActivity($activityModel)
                        ->withCalendars($googleCalendars)
                        ->withColors($colors);
    }

    public function update(Request $request, $id) {
        abort(501);
    }

    public function destroy($id) {
        //
    }

}
