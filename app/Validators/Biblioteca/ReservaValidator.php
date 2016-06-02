<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ReservaValidator extends LaravelValidator
{

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
