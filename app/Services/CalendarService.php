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
use Academic\User;
use Academic\Email;
use Academic\Calendar;

class CalendarService {

    private $calendarService;
    private $students;
    private $googleEmails;

    public function __construct(Google_Service_Calendar $calendarService) {
        $this->calendarService = $calendarService;
    }

    public function insertCalendar(Request $request) {
        $this->validateCalendar($request);

        $googleCalendar = $this->fillGoogleCalendar($request);
        $insertedCalendar = $this->calendarService->calendars->insert($googleCalendar);

        $email = new Email();
        $emails = $email->getEmails($request->attendees);

        $calendar = new Calendar();
        $calendar->calendar = $insertedCalendar->getId();
        $calendar->save();
        $calendar->emails()->saveMany($emails->all());

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
        //$this->disassociateAttendees($googleCalendar, $request->disassociate);
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


//        dd($calendars);
//        $this->listAssociatedStudentsByAcl($id);
//        $this->disassociateAttendees($calendar, $this->googleEmails);
//        $this->calendarService->calendars->delete($id);;
    }

//    public function deleteCalendar($id) {
//        $calendar = $this->getCalendar($id);
//        $this->listAssociatedStudentsByAcl($id);
//        $this->disassociateAttendees($calendar, $this->googleEmails);
//        $this->calendarService->calendars->delete($id);
//    }

    public function getCalendar($id) {
        return $this->calendarService->calendars->get($id);
    }

    // public function listAssociatedStudentsByAcl($id) {
    //     $user = Session::get('user');
    //     $googleEmail = new GoogleEmail();
    //     $list = $this->calendarService->acl->listAcl($id);
    //     foreach ($list->getItems() as $acl) {
    //         $emails[] = $acl->getScope()->getValue();
    //     }
    //     $eloquents = $googleEmail->whereIn('email', $emails)->where('email', '!=', $user->googleEmail->email)->get();
    //     $students = [];
    //     foreach ($eloquents as $eloquent) {
    //         $this->googleEmails[] = $eloquent->email;
    //         $students[] = $eloquent->user;
    //     }
    //     $this->students = $students;
    //     return $this->students;
    // }



    private function disassociateAttendee($id, $email) {
        $this->calendarService->acl->delete($id, 'user:' . $email);
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
        //$googleEmail = new GoogleEmail();
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
