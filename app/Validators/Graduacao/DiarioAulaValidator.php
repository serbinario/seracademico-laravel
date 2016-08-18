<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class DiarioAulaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [];

    protected $attributes = [];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'data' =>  '' ,
			'numero_aula' =>  '' ,
			'hora_inicial' =>  '' ,
			'hora_final' =>  '' ,
			'carga_horaria' =>  '' ,
			'turma_disciplina_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'data' =>  '' ,
			'numero_aula' =>  '' ,
			'hora_inicial' =>  '' ,
			'hora_final' =>  '' ,
			'carga_horaria' =>  '' ,
			'turma_disciplina_id' =>  '' ,

        ],
   ];

}
