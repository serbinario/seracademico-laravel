<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class BairroValidator extends LaravelValidator {

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
        'cidades_id' => 'Cidade'
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'nome' => 'required',
            'cidades_id' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'nome' => 'required',
            'cidades_id' => 'required'
        ],
   ];

}