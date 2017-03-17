<?php

namespace Academic\Http\Requests;

use Academic\Http\Requests\Request;

class LoginRequest extends Request {

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
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ];
    }

    /**
     * Get the rules messages that apply to the request.
     *
     * @return array
     */
    public function messages() {
        return [
            'username.required' => 'O campo Matrícula é necessário.',
            'username.max' => 'O campo Matrícula deve conter no máximo 255 caracteres.',
            'password.required' => 'O campo Senha é necessário.',
            'password.max' => 'O campo Senha deve conter no máximo 255 caracteres.'
        ];
    }

}
