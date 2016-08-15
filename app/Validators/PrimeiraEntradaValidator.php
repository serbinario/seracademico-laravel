<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PrimeiraEntradaValidator extends LaravelValidator
{
    protected $messages   = [];

    protected $attributes = [];

    protected $messages   = [];

    protected $attributes = [];
    
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'tipo_autor_id' =>  '' ,
			'arcevos_id' =>  '' ,
			'responsaveis_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
