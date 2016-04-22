<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EnderecoValidator extends LaravelValidator {

    protected $messages   = [
    ];

    protected $attributes = [
    ];
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'logradouro' => '',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'logradouro' => '',
        ],
   ];

}