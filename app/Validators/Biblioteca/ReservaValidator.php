<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ReservaValidator extends LaravelValidator
{

	use TraitReplaceRulesValidator;
	
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'codigo' =>  '' ,
			'data' =>  '' ,
			'data_vencimento' =>  '' ,
			'user_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'codigo' =>  '' ,
			'data' =>  '' ,
			'data_vencimento' =>  '' ,
			'user_id' =>  '' ,

        ],
   ];

}
