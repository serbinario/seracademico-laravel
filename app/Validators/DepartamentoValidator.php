<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class DepartamentoValidator extends LaravelValidator
{
    protected $messages   = [
    ];

    protected $attributes = [
    ];


    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'sede_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
