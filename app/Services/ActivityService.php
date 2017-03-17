<?php

namespace Academic\Services;

use Illuminate\Http\Request;
use Academic\Services\GoogleService;
use Academic\Services\EventService;
use Academic\Models\Calendar;
use Academic\Models\Activity;
use Academic\Models\Event;
use Academic\Models\Team;
use Academic\Http\Requests\ActivityRequest;
use Carbon\Carbon;
use Session;

class ActivityService {

    private $calendarService;

    public function __construct() {
        $googleService = new GoogleService();
        $this->calendarService = $googleService->getCalendarService();
    }

    public function index($id) {
        $activities = Activity::byTeam($id);
        $activitiesWithEvents = [];
        foreach ($activities as $activity) {
            $calendarEvent = $this->calendarService->events->get($activity->event->calendar->calendar, $activity->event->event);
            $date = Carbon::createFromFormat('Y-m-d', $calendarEvent->getStart()->getDate())->format('d/m/Y');
            $activitiesWithEvents[] = ['activity' => $activity, 'event' => $calendarEvent, 'date' => $date];
        }
        return $activitiesWithEvents;
    }

    public function store(ActivityRequest $request) {
        $team = Team::findOrFail($request->team_id);
        $eventService = new EventService();
        $request->merge(['all_day' => 'Y', 'begin_date' => $request->date, 'end_date' => $request->date]);
        $calendarEvent = $eventService->store($request);
        $calendar = Calendar::calendar($request->calendar);
        $event = new Event();
        $event->event = $calendarEvent['id'];
        $event->calendar()->associate($calendar);
        $event->save();
        $activity = new Activity();
        $activity->fill($request->all());
        $activity->event()->associate($event);
        $activity->team()->associate($team);
        $activity->save();
        foreach ($team->students as $student) {
            $activity->students()->attach($student->id, ['done' => '0', 'returned' => '0']);
        }
    }

    public function edit($id) {
        $activity = Activity::findOrFail($id);
        $calendarEvent = $this->calendarService->events->get($activity->event->calendar->calendar, $activity->event->event);
        $date = $calendarEvent->getStart()->getDate();
        return ['activity' => $activity, 'event' => $calendarEvent, 'date' => $date];
    }

    public function update(ActivityRequest $request, $id) {
        $eventService = new EventService();
        $request->merge(['all_day' => 'Y', 'begin_date' => $request->date, 'end_date' => $request->date]);
        $activity = Activity::findOrFail($id);
        $activity->fill($request->all());
        $activity->save();
        $eventService->update($request, $activity->event->event);
    }

    public function destroy($id) {
        $activity = Activity::findOrFail($id);
        $this->calendarService->events->delete($activity->event->calendar->calendar, $activity->event->event);
        $activity->delete();
    }

    public function show($id) {
        $activity = Activity::findOrFail($id);
        $users = $activity->students->map(function($student) {
            return ['personal' => $student->user, 'google' => $student->user->google, 'activity' => $student->pivot];
        });
        return ['activity' => $activity, 'users' => $users];
    }

    public function details(Request $request, $id) {
        Activity::find($id)->students()->updateExistingPivot($request->personal['student']['id'], ['done' => $request->activity['done'], 'returned' => $request->activity['returned'], 'grade' => $request->activity['grade']]);
    }

    public function fromStudent() {
        $user = Session::get('user');
        $total = 0;
        $hundred = 0;
        $result = 0;
        $partial = 0;
        $activities = $user->student->activities->map(function($activity) use ($total, $hundred, $result, $partial) {
            $event = $this->calendarService->events->get($activity->event->calendar->calendar, $activity->event->event);
            $hundred = (100 * $activity->weight) / $activity->total_score;
            $partial += $activity->pivot->grade * ($hundred / 100);
            $total += $activity->pivot->grade;
            return compact('activity', 'event', 'total', 'partial');
        });
        return $activities;
    }

}
