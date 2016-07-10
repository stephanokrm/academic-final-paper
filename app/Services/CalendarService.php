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
use Academic\Services\AclService;
use Academic\User;

class CalendarService {

    private $calendarService;
    private $students;

    public function __construct(Google_Service_Calendar $calendarService) {
        $this->calendarService = $calendarService;
    }

    public function insertCalendar(Request $request) {
        $this->validateCalendar($request);
        $googleCalendar = $this->fillGoogleCalendar($request);
        $insertedCalendar = $this->calendarService->calendars->insert($googleCalendar);
        $this->associateAttendees($insertedCalendar, $request);
    }

    public function updateCalendar(Request $request, $id) {
        $this->validateCalendar($request);
        $googleCalendar = $this->getCalendar($id);
        $googleCalendar = $this->fillGoogleCalendar($request, $googleCalendar);
        $this->disassociateAttendees($googleCalendar, $request->disassociate);
        $this->associateAttendees($googleCalendar, $request);
        $this->calendarService->calendars->update($googleCalendar->getId(), $googleCalendar);
    }

    public function deleteCalendar($id) {
        $service = new AclService($this->calendarService);
        $calendar = $this->getCalendar($id);
        $students = $service->listAssociatedStudentsByAcl($id);

        $emails = [];
        foreach ($students as $student) {
            $emails[] = $student->googleEmail->email;
        }
        $this->disassociateAttendees($calendar, $emails);
        $this->calendarService->calendars->delete($id);
    }

    public function getCalendar($id) {
        return $this->calendarService->calendars->get($id);
    }

    public function listAssociatedStudentsByAcl($id) {
        $service = new AclService($this->calendarService);
        $this->students = $service->listAssociatedStudentsByAcl($id);
        return $this->students;
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

    private function disassociateAttendees(Google_Service_Calendar_Calendar $calendar, $attendees) {
        if (!empty($attendees)) {
            $calendarId = $calendar->getId();
            foreach ($attendees as $attendee) {
                $this->calendarService->acl->delete($calendarId, 'user:' . $attendee);
            }
        }
    }

    private function validateCalendar(Request $request) {
        $validation = new CalendarValidation();
        $validation->validate($request);
    }

    public function getNotAssociatedStudentsFromForthYear() {

        $enrollments = [];

        foreach ($this->students as $student) {
            $enrollments[] = $student->matricula;
        }

        $student = new User();
        return $student->getNotAssociatedStudentsFromForthYear($enrollments);
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
