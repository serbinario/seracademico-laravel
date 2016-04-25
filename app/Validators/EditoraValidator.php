<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EditoraValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'email' =>  '' ,
			'site' =>  '' ,
			'cnpj' =>  '' ,
			'razao_social' =>  '' ,
			'agencia' =>  '' ,
			'conta' =>  '' ,
			'enderecos_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
