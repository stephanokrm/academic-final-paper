<?php

namespace Academic\Services;

use Illuminate\Http\Request;
//
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_AclRule;
use Google_Service_Calendar_AclRuleScope;
//
use Academic\Validations\CalendarValidation;
use Academic\Google;
use Academic\Calendar;
use Academic\Team;
use Academic\User;
use Session;
use Crypt;

class CalendarService {

    private $calendarService;
    private $user;

    public function __construct(Google_Service_Calendar $calendarService) {
        $this->calendarService = $calendarService;
        $this->user = Session::get('user');
    }

    public function listCalendars() {
        $googleCalendars = [];
        $calendar = new Calendar();
        $calendars = $this->calendarService->calendarList->listCalendarList();
        if (!empty($calendars)) {
            foreach ($calendars as $googleCalendar) {
                if ($calendar->exists($googleCalendar->getId())) {
                    $googleCalendars[] = $googleCalendar;
                }
            }
        }
        return $googleCalendars;
    }

    private function associateAttendees(Google_Service_Calendar_Calendar $calendar, Request $request, $googleEmails) {
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

    public function updateCalendar(Request $request, $id) {
        $this->validateCalendar($request);
        $googleCalendar = $this->getCalendar($id);
        $googleCalendar = $this->fillGoogleCalendar($request, $googleCalendar);

        $attendees = $request->attendees;
        $disassociate = $request->disassociate;

        $google = new Google();
        $addEmails = $google->getEmails($attendees);
        $removeEmails = $google->getEmails($disassociate);

        foreach ($removeEmails as $google) {
            $this->disassociateAttendee($id, $google->email);
        }

        $calendar = new Calendar();
        $calendar = $calendar->getCalendar($id);

        foreach ($removeEmails as $removeEmail) {
            $calendar->googles()->detach($removeEmail->id);
        }

        foreach ($addEmails as $addEmail) {
            $calendar->googles()->attach($addEmail->id);
        }

        $this->associateAttendees($googleCalendar, $request);
        $this->calendarService->calendars->update($googleCalendar->getId(), $googleCalendar);
    }

    public function getCalendar($id) {
        return $this->calendarService->calendars->get($id);
    }

    private function disassociateAttendee($id, $email) {
        $this->calendarService->acl->delete($id, 'user:' . $email);
    }

    private function validateCalendar(Request $request) {
        $validation = new CalendarValidation();
        $validation->validate($request);
    }

    public function index() {
        if ($this->user->isTeacher()) {
            return $this->getAllCalendarsFromTeacher();
        } else {
            return $this->getAllCalendarsFromStudent();
        }
    }

    public function create() {
        if ($this->user->isTeacher()) {
            return Team::getTeamsFromTeacher();
        } else {
            return User::getUsersByTeamExceptLoggedUser();
        }
    }

    public function store(Request $request) {
        $this->validateCalendar($request);
        $teamId = $this->user->isTeacher() ? $request->team : $this->user->student->team_id;
        $googleEmails = $this->user->isTeacher() ? Google::getEmailsByTeam($teamId) : $request->attendees;
        $googleCalendar = $this->fillGoogleCalendar($request);
        $insertedCalendar = $this->calendarService->calendars->insert($googleCalendar);
        $google = new Google();
        $googles = $google->getEmails($googleEmails);
        $calendar = new Calendar();
        $calendar->calendar = $insertedCalendar->getId();
        $calendar->team()->associate(Team::findOrFail($teamId));
        $calendar->save();
        $allGoogles = $this->user->isTeacher() ? $googles->all() : array_merge($googles->all(), [$this->user->google]);
        $calendar->googles()->saveMany($allGoogles);
        $this->associateAttendees($insertedCalendar, $request, $googleEmails);
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

    private function fillGoogleCalendar(Request $request, Google_Service_Calendar_Calendar $googleCalendar = null) {
        if (is_null($googleCalendar)) {
            $googleCalendar = new Google_Service_Calendar_Calendar();
        }
        $googleCalendar->setSummary($request->summary);
        return $googleCalendar;
    }

    public function destroy($id) {
        $calendarId = Crypt::decrypt($id);
        $calendar = new Calendar();
        $calendarEloquent = $calendar->getCalendar($calendarId);
        $googles = Google::getGooglesCalendarsExceptCreator($this->user->google->id, $calendarEloquent->id);
        foreach ($googles as $google) {
            $this->disassociateAttendee($calendarEloquent->calendar, $google->email);
        }
        $calendarEloquent->googles()->sync([], true);
        $calendarEloquent->delete();
        $this->calendarService->calendars->delete($calendarId);
    }

}
