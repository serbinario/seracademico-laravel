<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class EditoraValidator extends LaravelValidator
{

	use TraitReplaceRulesValidator;

	protected $messages   = [];

	protected $attributes = [];
	
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
