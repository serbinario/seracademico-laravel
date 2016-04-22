<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class TurmaValidator extends LaravelValidator
{
	protected $messages   = [];

	protected $attributes = [];

    protected $rules      = [
        ValidatorInterface::RULE_CREATE => [
            
			'curriculo_id' =>  '' ,
			'turno_id' =>  '' ,
			'sigla' =>  '' ,
			'valor_turma' =>  '' ,
			'valor_disciplina' =>  '' ,
			'sala_id' =>  '' ,
			'obs_sala' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
