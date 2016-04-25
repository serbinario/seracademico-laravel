<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class TipoCursoValidator extends LaravelValidator
{

    protected $messages   = [
    ];

    protected $attributes = [
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  'unique:fac_tipo_cursos' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            'nome' =>  'unique:fac_tipo_cursos' ,
        ],
   ];

}
