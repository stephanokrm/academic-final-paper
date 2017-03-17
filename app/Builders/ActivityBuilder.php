<?php

namespace Academic\Builders;

use Academic\Models\Activity;

class ActivityBuilder implements Builder {

    private $activity;

    public function create() {
        $this->activity = new Activity();
        return $this;
    }

    public function edit() {
        
    }

    public function get() {
        return $this->activity;
    }

    public function addWeight($weight) {
        $this->activity->weight = $weight;
        return $this;
    }

    public function addTotalScore($totalScore) {
        $this->activity->total_score = $totalScore;
        return $this;
    }

}
