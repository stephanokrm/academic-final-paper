<?php

namespace Academic\Validations;

use Illuminate\Http\Request;
use Validator;
use Academic\Exceptions\FormValidationException;

class EventValidation {

    public function validate(Request $request) {

        Validator::extend('before_equal', function($attribute, $value, $parameters, $validator) {
            return strtotime($validator->getData()[$parameters[0]]) >= strtotime($value);
        });

        Validator::extend('after_equal', function($attribute, $value, $parameters, $validator) {
            return strtotime($validator->getData()[$parameters[0]]) <= strtotime($value);
        });

        $rules = ['summary' => 'required|max:255',
//            'begin_date' => 'required|date_format:d/m/Y|before_equal:end_date',
            'begin_time' => 'required_without:all_day|date_format:H:i',
//            'end_date' => 'required|date_format:d/m/Y|after_equal:begin_date',
            'end_time' => 'required_without:all_day|date_format:H:i',
            'street' => 'required_if:include_address,Y|max:255',
            'number' => 'required_if:include_address,Y|max:6',
            'district' => 'required_if:include_address,Y|max:255',
            'city' => 'required_if:include_address,Y|max:255',
            'state' => 'required_if:include_address,Y|max:255',
            'country' => 'required_if:include_address,Y|max:255',
            'description' => 'max:500',
            'color' => 'required|in:1,2,3,4,5,6,7,8,9,10,11'];

        $messages = ['summary.required' => 'O campo Título é necessário.',
            'summary.max' => 'O campo Título deve conter no máximo 255 caracteres.',
            'begin_date.required' => 'O campo Data de Início é necessário.',
            'begin_date.date_format' => 'O campo Data de Início não corresponde ao formato DD/MM/YYYY.',
//            'begin_date.before_equal' => 'O campo Data de Início deve conter uma data anterior à ' . $request->end_date,
            'begin_time.required_without' => 'O campo Hora de Início é necessário quando Dia Inteiro não for selecionado.',
            'begin_time.date_format' => 'O campo Hora de Início não corresponde ao formato HH:MM.',
            'end_date.required' => 'O campo Data de Término é necessário.',
            'end_date.date_format' => 'O campo Data de Término não corresponde ao formato DD/MM/YYYY.',
//            'end_date.after_equal' => 'O campo Data de Término deve conter uma data posterior à ' . $request->begin_date,
            'end_time.required_without' => 'O campo Hora de Término é necessário quando Dia Inteiro não for selecionado.',
            'end_time.date_format' => 'O campo Hora de Término não corresponde ao formato HH:MM.',
            'street.required_if' => 'O campo Rua é necessário quando Incluir Endereço for selecionado.',
            'street.max' => 'O campo Rua deve conter no máximo 255 caracteres.',
            'number.required_if' => 'O campo Número é necessário quando Incluir Endereço for selecionado.',
            'number.max' => 'O campo Número deve conter no máximo 6 caracteres.',
            'district.required_if' => 'O campo Estado é necessário quando Incluir Endereço for selecionado.',
            'district.max' => 'O campo Estado deve conter no máximo 255 caracteres.',
            'city.required_if' => 'O campo Cidade é necessário quando Incluir Endereço for selecionado.',
            'city.max' => 'O campo Cidade deve conter no máximo 255 caracteres.',
            'state.required_if' => 'O campo Estado é necessário quando Incluir Endereço for selecionado.',
            'state.max' => 'O campo Estado deve conter no máximo 255 caracteres.',
            'country.required_if' => 'O campo País é necessário quando Incluir Endereço for selecionado.',
            'country.max' => 'O campo País deve conter no máximo 255 caracteres.',
            'description.max' => 'O campo Descrição deve conter no máximo 500 caracteres.',
            'color.required' => 'O campo Cor do Evento é necessário.',
            'color.in' => 'O campo Cor do Evento deve conter um valor válido.'];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new FormValidationException($errors);
        }
    }

}
