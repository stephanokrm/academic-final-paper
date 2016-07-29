<?php

namespace Academic\Models;

class ActivityModel {

    private $id;
    private $summary;
    private $weight;
    private $totalScore;
    private $description;
    private $date;
    private $colorId;

    public function getId() {
        return $this->id;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function getTotalScore() {
        return $this->totalScore;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDate() {
        return $this->date;
    }

    public function getColorId() {
        return $this->colorId;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSummary($summary) {
        $this->summary = $summary;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function setTotalScore($totalScore) {
        $this->totalScore = $totalScore;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setColorId($colorId) {
        $this->colorId = $colorId;
    }

}
