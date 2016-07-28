<?php

namespace Academic\Services;

use Academic\Activity;

class AcitivityService {

    public function getActivitiesFromTeam($id) {
        return Activity::where('team_id', $id)->get();
    }

}
