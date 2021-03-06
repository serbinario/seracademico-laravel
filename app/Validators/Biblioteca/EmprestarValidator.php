<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class EmprestarValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

	protected $messages   = [];

	protected $attributes = [];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'pessoas_id' =>  'required' ,
			'codigo' =>  '' ,
			'data' =>  '' ,
			'data_devolucao' =>  '' ,
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
