<?php

namespace Academic\Http\Controllers;

use Academic\Http\Controllers\Controller;
use Academic\Services\AcitivityService;
use Academic\Services\GoogleService;
use Illuminate\Http\Request;
use Google_Service_Calendar;

class ActivityController extends Controller {

    private $calendarService;

    public function __construct() {
        $service = new GoogleService();
        $client = $service->getClient();
        $this->calendarService = new Google_Service_Calendar($client);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id) {
        $service = new AcitivityService();
        $activities = $service->getActivitiesFromTeam($id);
        return view('activities.index')->withActivities($activities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        die('AQUI');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
