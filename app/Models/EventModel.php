<?php

namespace Academic\Models;

class EventModel {

    private $id;
    private $summary;
    private $description;
    private $allDay;
    private $beginDate;
    private $beginTime = null;
    private $beginDateTime;
    private $originalBeginDate;
    private $endDate;
    private $endTime = null;
    private $endDateTime;
    private $originalEndDate;
    private $colorId;
    private $calendar;

    function getCalendar() {
        return $this->calendar;
    }

    function setCalendar($calendar) {
        $this->calendar = $calendar;
    }

    function getBeginDateTime() {
        return $this->beginDateTime;
    }

    function getEndDateTime() {
        return $this->endDateTime;
    }

    function setBeginDateTime($beginDateTime) {
        $this->beginDateTime = $beginDateTime;
    }

    function setEndDateTime($endDateTime) {
        $this->endDateTime = $endDateTime;
    }

    function getOriginalBeginDate() {
        return $this->originalBeginDate;
    }

    function getOriginalEndDate() {
        return $this->originalEndDate;
    }

    function setOriginalBeginDate($originalBeginDate) {
        $this->originalBeginDate = $originalBeginDate;
    }

    function setOriginalEndDate($originalEndDate) {
        $this->originalEndDate = $originalEndDate;
    }

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getSummary() {
        return $this->summary;
    }

    function getAllDay() {
        return $this->allDay;
    }

    function getBeginDate() {
        return $this->beginDate;
    }

    function getBeginTime() {
        return $this->beginTime;
    }

    function getEndDate() {
        return $this->endDate;
    }

    function getEndTime() {
        return $this->endTime;
    }

    function getColorId() {
        return $this->colorId;
    }

    function setColorId($id) {
        $this->colorId = $id;
    }

    function setSummary($summary) {
        $this->summary = $summary;
    }

    function setAllDay($allDay) {
        $this->allDay = $allDay;
    }

    function setBeginDate($beginDate) {
        $this->beginDate = $beginDate;
    }

    function setBeginTime($beginTime) {
        $this->beginTime = is_null($beginTime) ? $beginTime : ' - ' . $beginTime;
    }

    function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    function setEndTime($endTime) {
        $this->endTime = is_null($endTime) ? $endTime : ' - ' . $endTime;
    }

    public function isAllDay() {
        return $this->allDay == true;
    }

    public function hasDescription() {
        return $this->description != '';
    }

}
