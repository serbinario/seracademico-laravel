<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ArcevoValidator extends LaravelValidator
{

    use TraitReplaceRulesValidator;

    protected $messages   = [];

    protected $attributes = [];


    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
