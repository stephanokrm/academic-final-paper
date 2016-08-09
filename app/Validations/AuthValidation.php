<?php

namespace Academic\Validations;

use Illuminate\Http\Request;
use Validator;
use Academic\Exceptions\FormValidationException;

class AuthValidation {

    public function validate(Request $request) {

        $rules = [
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ];

        $messages = [
            'username.required' => 'O campo Matrícula é necessário.',
            'username.max' => 'O campo Matrícula deve conter no máximo 255 caracteres.',
            'password.required' => 'O campo Senha é necessário.',
            'password.max' => 'O campo Senha deve conter no máximo 255 caracteres.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new FormValidationException($errors);
        }
    }

}
