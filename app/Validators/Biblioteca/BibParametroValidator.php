<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class BibParametroValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'valor' =>  '' ,
			'codigo' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'nome' =>  '' ,
			'valor' =>  '' ,
			'codigo' =>  '' ,

        ],
   ];

}
