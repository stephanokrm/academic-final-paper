<?php

namespace Academic\Validations;

use Illuminate\Http\Request;
use Validator;
use Academic\Exceptions\FormValidationException;
use Carbon\Carbon;

class RegisterValidation {

    public function validate(Request $request) {

        $rules = [
        	'birth_date' => 'required|date_format:d/m/Y|before:' . Carbon::now(),
            'email' => 'required|email|max:255'
        ];

        $messages = [
        	'birth_date.required' => 'O campo Data de Nascimento é necessário.',
        	'birth_date.date_format' => 'O campo Data de Nascimento não corresponde ao formato DD/MM/YYYY.',
            'birth_date.before' => 'O campo Data de Nascimento deve conter uma data anterior à de hoje.',
            'email.required' => 'O campo E-mail Google é necessário.',
            'email.email' => 'O campo E-mail Google deve conter um e-mail válido.',
            'email.max' => 'O campo E-mail Google deve conter no máximo 255 caracteres.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new FormValidationException($errors);
        }
    }

}
