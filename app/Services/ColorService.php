<?php

namespace Academic\Services;

use Academic\Services\GoogleService;

class ColorService {

    private $calendarService;

    public function __construct() {
        $googleService = new GoogleService();
        $this->calendarService = $googleService->getCalendarService();
    }

    public function index() {
        return $this->calendarService->colors->get();
    }
    
}
