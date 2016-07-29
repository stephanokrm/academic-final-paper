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
    private $includeAddress;
    private $street = null;
    private $district = null;
    private $number = null;
    private $city = null;
    private $state = null;
    private $country = null;
    private $colorId;

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

    function getIncludeAddress() {
        return $this->includeAddress;
    }

    function getStreet() {
        return $this->street;
    }

    function getDistrict() {
        return $this->district;
    }

    function getNumber() {
        return $this->number;
    }

    function getCity() {
        return $this->city;
    }

    function getState() {
        return $this->state;
    }

    function getCountry() {
        return $this->country;
    }

    function getColorId() {
        return $this->colorId;
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

    function setIncludeAddress($includeAddress) {
        $this->includeAddress = $includeAddress;
    }

    public function hasAddress() {
        return $this->includeAddress == true;
    }

    function setStreet($street) {
        $this->street = $street;
    }

    function setDistrict($district) {
        $this->district = $district;
    }

    function setNumber($number) {
        $this->number = $number;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setCountry($country) {
        $this->country = $country;
    }

    function setColorId($colorId) {
        $this->colorId = $colorId;
    }

    public function isAllDay() {
        return $this->allDay == true;
    }

    public function hasDescription() {
        return $this->description != '';
    }

}
