<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EmprestarValidator extends LaravelValidator
{
    //use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'pessoas_id' =>  'required' ,
			'codigo' =>  '' ,
			'data' =>  '' ,
			'data_devolucao' =>  'required' ,
			'data_devolucao_real' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'user_id' =>  '' ,
			'codigo' =>  '' ,
			'data' =>  '' ,
			'data_devolucao' =>  '' ,
			'data_devolucao_real' =>  '' ,

        ],
   ];

}
