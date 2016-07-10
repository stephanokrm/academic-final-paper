<?php

namespace Academic\Services;

use Google_Service_Calendar;
//
use Academic\GoogleEmail;
use Session;

class AclService {

    private $calendarService;

    public function __construct(Google_Service_Calendar $calendarService) {
        $this->calendarService = $calendarService;
    }

    public function listAssociatedStudentsByAcl($id) {
        $user = Session::get('user');
        $googleEmail = new GoogleEmail();
        $list = $this->calendarService->acl->listAcl($id);

        foreach ($list->getItems() as $acl) {
            $emails[] = $acl->getScope()->getValue();
        }

        $eloquents = $googleEmail->whereIn('email', $emails)->where('email', '!=', $user->googleEmail->email)->get();

        $students = [];

        foreach ($eloquents as $eloquent) {
            $students[] = $eloquent->user;
        }

        return $students;
    }

}
