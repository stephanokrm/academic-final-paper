<?php

namespace Academic\Services;

use Session;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_AclRule;
use Google_Service_Calendar_AclRuleScope;
use Academic\Http\Requests\CalendarRequest;
use Illuminate\Http\Request;
use Academic\Services\GoogleService;
use Academic\Team;
use Academic\Google;
use Academic\Calendar;

class CalendarService {

    private $calendarService;
    private $user;

    public function __construct() {
        $googleService = new GoogleService();
        $this->calendarService = $googleService->getCalendarService();
        $this->user = Session::get('user');
    }

    public function index() {
        if ($this->user->isTeacher()) {
            return $this->getAllCalendarsFromTeacher();
        } else {
            return $this->getAllCalendarsFromStudent();
        }
    }

    public function store(CalendarRequest $request) {
        $teamId = $this->user->isTeacher() ? $request->team : $this->user->student()->first()->team_id;
        $googleEmails = $this->user->isTeacher() ? Google::emailsByTeam($teamId) : $request->attendees;
        $googleCalendar = $this->fillGoogleCalendar($request);
        $insertedCalendar = $this->calendarService->calendars->insert($googleCalendar);
        $googles = Google::emails($googleEmails);
        $calendar = new Calendar();
        $calendar->calendar = $insertedCalendar->getId();
        $calendar->team()->associate(Team::findOrFail($teamId));
        $calendar->save();
        $allGoogles = $this->user->isTeacher() ? $googles->all() : array_merge($googles->all(), [$this->user->google]);
        $calendar->googles()->saveMany($allGoogles);
        $this->associateAttendees($insertedCalendar, $request, $googleEmails);
        return $insertedCalendar;
    }

    public function destroy($id) {
        $calendarEloquent = Calendar::calendar($id);
        $googles = Google::googlesCalendarsExceptCreator($this->user->google->id, $calendarEloquent->id);
        foreach ($googles as $google) {
            $this->disassociateAttendee($calendarEloquent->calendar, $google->email);
        }
        $calendarEloquent->googles()->sync([], true);
        $calendarEloquent->delete();
        $this->calendarService->calendars->delete($id);
    }

    public function attendees($id) {
        $calendar = Calendar::calendar($id);
        return $calendar->googles;
    }

    public function notAttendees($id) {
        $calendar = Calendar::calendar($id);
        $attendeesEmails = $calendar->getAttendeesEmails();
        return Google::disassociated($attendeesEmails);
    }

    public function addAttendee(Request $request) {
        $google = Google::email($request->attendee['email']);
        $calendar = Calendar::calendar($request->id);
        $calendar->googles()->attach($google->id);
        $insertedCalendar = $this->calendarService->calendars->get($request->id);
        $this->associateAttendees($insertedCalendar, $request, [$request->attendee['email']]);
    }

    public function removeAttendee(Request $request) {
        $google = Google::email($request->attendee['email']);
        $calendar = Calendar::calendar($request->id);
        $this->disassociateAttendee($calendar->calendar, $google->email);
        $calendar->googles()->detach($google->id);
    }

    public function update(CalendarRequest $request, $id) {
        $calendar = $this->calendarService->calendars->get($id);
        $calendar = $this->fillGoogleCalendar($request, $calendar);
        $this->calendarService->calendars->update($calendar->getId(), $calendar);
    }

    private function getAllCalendarsFromTeacher() {
        $team = new Team();
        
        $ids = $team->getTeamsFromTeacherIds($this->user->teacher->id);
        $calendarsGoogleIds = Calendar::getCalendarGoogleIdsFromTeams($ids);
        return $this->filterCalendars($calendarsGoogleIds);
    }

    private function getAllCalendarsFromStudent() {
        $calendarsGoogleIds = Calendar::getCalendarsIdsByGoogleId($this->user->google->id);
        return $this->filterCalendars($calendarsGoogleIds);
    }

    private function filterCalendars($calendarsGoogleIds) {
        $calendarList = $this->calendarService->calendarList->listCalendarList();
        return array_filter($calendarList->getItems(), function($googleCalendar) use ($calendarsGoogleIds) {
            if (in_array($googleCalendar->getId(), $calendarsGoogleIds)) {
                return $googleCalendar;
            }
        });
    }

    private function fillGoogleCalendar(CalendarRequest $request, Google_Service_Calendar_Calendar $googleCalendar = null) {
        if (is_null($googleCalendar)) {
            $googleCalendar = new Google_Service_Calendar_Calendar();
        }
        $googleCalendar->setSummary($request->summary);
        return $googleCalendar;
    }

    private function associateAttendees(Google_Service_Calendar_Calendar $calendar, $request, $googleEmails) {
        if (!empty($googleEmails)) {
            $role = $this->user->isTeacher() ? 'reader' : $request->role;
            $rule = new Google_Service_Calendar_AclRule();
            $scope = new Google_Service_Calendar_AclRuleScope();
            $scope->setType('group');
            foreach ($googleEmails as $attendee) {
                $scope->setValue($attendee);
                $rule->setScope($scope);
                $rule->setRole($role);
                $this->calendarService->acl->insert($calendar->getId(), $rule);
            }
        }
    }

    private function disassociateAttendee($id, $email) {
        $this->calendarService->acl->delete($id, 'user:' . $email);
    }

}
