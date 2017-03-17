<?php

namespace Academic\Http\Requests;

use Academic\Http\Requests\Request;

class ActivityRequest extends Request {

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
            'calendar' => 'required|email',
            'date' => 'required',
            'weight' => ['required', 'regex:/^(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'total_score' => ['required', 'regex:/^(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'description' => 'max:500',
            'color' => 'required|in:5,10,11'
        ];
    }

    public function messages() {
        return [
            'calendar.required' => 'O campo Calendário é necessário.',
            'calendar.email' => 'O campo Calendário deve ser um e-mail válido.',
            'date.required' => 'O campo Data de Início é necessário.',
            'weight.required' => 'O campo Peso é necessário.',
            'weight.regex' => 'O formato do campo Peso é inválido.',
            'total_score.required' => 'O campo Nota Máxima é necessário.',
            'total_score.regex' => 'O formato do campo Nota Máxima é inválido.'
        ];
    }

}
