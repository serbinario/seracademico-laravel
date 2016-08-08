<?php

namespace Seracademico\Validators\Financeiro;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class BeneficioValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

	protected $messages   = [];
	protected $attributes = [];
	
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'data_inicio' =>  '' ,
			'data_fim' =>  '' ,
			'valor' =>  '' ,
			'tipo_beneficio_id' =>  '' ,
			'aluno_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'data_inicio' =>  '' ,
			'data_fim' =>  '' ,
			'valor' =>  '' ,
			'tipo_beneficio_id' =>  '' ,
			'aluno_id' =>  '' ,

        ],
   ];

}
