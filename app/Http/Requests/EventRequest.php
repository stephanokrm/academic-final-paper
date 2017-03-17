<?php

namespace Academic\Http\Requests;

use Academic\Http\Requests\Request;

class EventRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'summary' => 'required|max:255',
            'begin_date' => 'required',
            'begin_time' => 'required_without:all_day|date_format:H:i',
            'end_date' => 'required',
            'end_time' => 'required_without:all_day|date_format:H:i',
            'description' => 'max:500',
            'color' => 'required|in:1,2,3,4,5,6,7,8,9,10,11'
        ];
    }

}
