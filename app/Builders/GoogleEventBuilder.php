<?php

namespace Academic\Builders;

use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

class GoogleEventBuilder implements Builder {

    private $event;

    public function create() {
        $this->event = new Google_Service_Calendar_Event();
        return $this;
    }
    
    public function edit($event) {
        $this->event = $event;
        return $this;
    }

    public function get() {
        return $this->event;
    }

    public function addSummary($summary) {
        $this->event->setSummary($summary);
        return $this;
    }

    public function addDescription($description) {
        $this->event->setDescription($description);
        return $this;
    }

    public function addColor($color) {
        $this->event->setColorId($color);
        return $this;
    }

    public function addStartDate($date) {
        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDate($date);
        $this->event->setStart($start);
        return $this;
    }

    public function addEndDate($date) {
        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDate($date);
        $this->event->setEnd($end);
        return $this;
    }

    public function addStartDateTime($date, $time) {;
        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime($date . 'T' . $time . ':00.000-00:00');
        $this->event->setStart($start);
        return $this;
    }

    public function addEndDateTime($date, $time) {
        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($date . 'T' . $time . ':00.000-00:00');
        $this->event->setEnd($end);
        return $this;
    }

}
