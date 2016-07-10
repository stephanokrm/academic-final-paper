<?php

namespace Academic\Validations;

use Illuminate\Http\Request;
use Validator;
use Academic\Exceptions\FormValidationException;

class CalendarValidation {

    public function validate(Request $request) {

        $rules = ['summary' => 'required|max:255',
            'attendees' => 'required_if:role,none,reader,writer,owner',
            'role' => 'in:none,reader,writer,owner'];

        $messages = ['summary.required' => 'O campo Título é necessário.',
            'summary.max' => 'O campo Título deve conter no máximo 255 caracteres.',
            'attendees.required_if' => 'O campo Aluno é necessário quando Permissão for selecionado.',
            'role.in' => 'O campo Permissão deve conter um valor válido.'];

        $attendees = $request->attendees;

        if (!empty($attendees)) {
            $rules['role'] = 'required';
            $messages['role.required'] = 'O campo Permissão é necessário quando Aluno for selecionado.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new FormValidationException($errors);
        }
    }

}
