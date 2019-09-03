<?php

namespace Academic\Http\Controllers;

use Academic\Http\Requests\ActivityRequest;
use Illuminate\Http\Request;
use Academic\Services\ActivityService;

class ActivityController extends Controller {

    protected $service;

    public function __construct(ActivityService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id) {
        $activities = $this->service->index($id);
        return response()->json($activities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ActivityRequest $request) {
        $this->service->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $activity = $this->service->show($id);
        return response()->json($activity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $activity = $this->service->edit($id);
        return response()->json($activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(ActivityRequest $request, $id) {
        $this->service->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->service->destroy($id);
    }

    public function details(Request $request, $id) {
        $this->service->details($request, $id);
    }

    public function fromStudent() {
        $activities = $this->service->fromStudent();
        return response()->json(compact('activities'));
    }

}
