<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ReservaExemplarValidator extends LaravelValidator
{
    //use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'reserva_id' =>  '' ,
			'exemplar_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'reserva_id' =>  '' ,
			'exemplar_id' =>  '' ,

        ],
   ];

}
