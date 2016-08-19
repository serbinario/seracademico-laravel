<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ResponsavelValidator extends LaravelValidator
{

    use TraitReplaceRulesValidator;

    protected $messages   = [];

    protected $attributes = [];
    
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  'unique:responsaveis,nome' ,
			'sobrenome' =>  '',
        ],
        
        ValidatorInterface::RULE_UPDATE => [
            'nome' =>  'required|unique:responsaveis,nome,:id',
            'sobrenome' =>  '',
        ],
   ];

}
