<?php

namespace Academic\Validations;

use Illuminate\Http\Request;
use Validator;
use Academic\Exceptions\FormValidationException;

class ActivityValidation {

    public function validate(Request $request) {

        $rules = [
            'calendar_id' => 'required|email',
            'date' => 'required|date_format:d/m/Y',
            'weight' => ['required', 'regex:/^(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'total_score' => ['required', 'regex:/^(?:[1-9]\d*|0)?(?:\.\d+)?$/']
        ];

        $messages = [
            'calendar_id.required' => 'O campo Calendário é necessário.',
            'calendar_id.email' => 'O campo Calendário deve ser um e-mail válido.',
            'date.required' => 'O campo Data de Início é necessário.',
            'date.date_format' => 'O campo Data de Início não corresponde ao formato DD/MM/YYYY.',
            'weight.required' => 'O campo Peso é necessário.',
            'weight.regex' => 'O formato do campo Peso é inválido.',
            'total_score.required' => 'O campo Nota Máxima é necessário.',
            'total_score.regex' => 'O formato do campo Nota Máxima é inválido.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new FormValidationException($errors);
        }
    }

}
