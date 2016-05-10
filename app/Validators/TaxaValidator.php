<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class TaxaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'codigo' =>  '' ,
			'nome' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'codigo' =>  '' ,
			'nome' =>  '' ,

        ],
   ];

}
