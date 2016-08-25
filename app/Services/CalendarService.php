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

class CalendarService {

    private $calendarService;

    public function __construct(Google_Service_Calendar $calendarService) {
        $this->calendarService = $calendarService;
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

    public function insertCalendar(Request $request, $teamId) {
        $this->validateCalendar($request);
        $team = Team::findOrFail($teamId);
        $google = new Google();
        $calendar = new Calendar();
        $googleCalendar = $this->fillGoogleCalendar($request);
        $insertedCalendar = $this->calendarService->calendars->insert($googleCalendar);
        $attendees = $request->attendees;
        $googles = $google->getEmails($attendees);
        $calendar->calendar = $insertedCalendar->getId();
        $calendar->team()->associate($team);
        $calendar->save();
        $calendar->googles()->saveMany($googles->all());
        $this->associateAttendees($insertedCalendar, $request);
    }

    private function associateAttendees(Google_Service_Calendar_Calendar $calendar, Request $request) {
        $attendees = $request->attendees;
        if (!empty($attendees)) {
            $role = $request->role;
            $calendarId = $calendar->getId();
            $rule = new Google_Service_Calendar_AclRule();
            $scope = new Google_Service_Calendar_AclRuleScope();
            $scope->setType('group');

            foreach ($attendees as $attendee) {
                $scope->setValue($attendee);
                $rule->setScope($scope);
                $rule->setRole($role);
                $this->calendarService->acl->insert($calendarId, $rule);
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

    public function deleteCalendar(Request $request) {
        $calendar = new Calendar();
        foreach ($request->calendars as $id) {
            $calendarEloquent = $calendar->getCalendar($id);
            if (is_object($calendarEloquent)) {
                $calendars[] = $calendarEloquent;
            }
        }

        foreach ($calendars as $calendar) {
            $id = $calendar->calendar;
            foreach ($calendar->googles as $google) {
                $this->disassociateAttendee($id, $google->email);
            }
            $calendar->googles()->sync([], true);
            $calendar->delete();
            $this->calendarService->calendars->delete($id);
        }
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

    private function fillGoogleCalendar(Request $request, Google_Service_Calendar_Calendar $googleCalendar = null) {

        if (is_null($googleCalendar)) {
            $googleCalendar = new Google_Service_Calendar_Calendar();
        }

        $googleCalendar->setSummary($request->summary);

        return $googleCalendar;
    }

}
