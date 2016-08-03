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

    public function insertCalendar(Request $request) {
        $this->validateCalendar($request);

        $googleCalendar = $this->fillGoogleCalendar($request);
        $insertedCalendar = $this->calendarService->calendars->insert($googleCalendar);

        $attendees = $request->attendees;

        $email = new Google();
        $emails = $email->getEmails($attendees);

        $calendar = new Calendar();
        $calendar->calendar = $insertedCalendar->getId();
        $calendar->save();
        $calendar->googles()->saveMany($emails->all());

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

        $email = new Google();
        $addEmails = $email->getEmails($attendees);
        $removeEmails = $email->getEmails($disassociate);

        foreach ($removeEmails as $email) {
            $this->disassociateAttendee($id, $email->email);
        }

        $calendar = new Calendar();
        $calendar = $calendar->getCalendar($id);

        foreach ($removeEmails as $removeEmail) {
            $calendar->emails()->detach($removeEmail->id);
        }

        foreach ($addEmails as $addEmail) {
            $calendar->emails()->attach($addEmail->id);
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
            foreach ($calendar->emails as $email) {
                $this->disassociateAttendee($id, $email->email);
            }
            $calendar->emails()->sync([], true);
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
        $googleCalendar->setDescription($request->description);
        $googleCalendar->setLocation($request->location);
        $googleCalendar->setTimeZone($request->time_zone);

        return $googleCalendar;
    }

}
