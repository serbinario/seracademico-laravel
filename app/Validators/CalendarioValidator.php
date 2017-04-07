<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class CalendarioValidator extends LaravelValidator {

    protected $messages   = [
        'required' => ':attribute é requerido',
        'between' => ':attribute deve conter no mínimo :min e no máximo :max caracteres',
        'serbinario_alpha_space' => ':attribute deve conter apenas letras e espaços',
        'bank_br' => ':attribute deve conter apenas números e no máximo um hífen (-)',
        'max' => ':attribute deve conter no máximo :size caracteres',
        'cpf_br' => ':attribute deve conter apenas números',
        'integer' => ':attribute deve conter apenas número(s) inteiro(s)',
        'unique' => ':attribute informado já se encontra cadastrado, por favor informe outro',
        'serbinario_date_format:"d/m/Y"' => ':attribute deve estar disposto como: dia/mês/ano',
        'decimal' => ':attribute deve conter um valor acima de 0, máximo uma vírgula e sem pontos',
        'serbinario_array_not_elements_files' => ':attribute é requerido'
    ];

    protected $attributes = [
        'nome' => 'Nome',
        'ano' => 'Ano'
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'nome' => 'required|max:150',
            'ano' => 'required|numeric|unique:fac_calendarios_escolares,ano|max:9999'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'nome' => 'required|max:150',
            'ano' => 'required|numeric|max:9999'
        ],
   ];

}