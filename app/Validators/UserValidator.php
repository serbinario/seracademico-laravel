<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator
{
    protected $messages   = [
        'unique' => 'O :attribute informado já se encontra cadastrado'
    ];

    protected $attributes = [
        'name' => 'Nome',
        'email' => 'E-mail',
        'password' => 'Senha',
        'active' => 'Ativo',
        'sede_id' => 'Polo'
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            /*'name' => '',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'active' => '',
            'sede_id' => 'required'*/
        ],

        ValidatorInterface::RULE_UPDATE => [

        ],
    ];


}