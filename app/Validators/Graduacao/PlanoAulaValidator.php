<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class PlanoAulaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [];

    protected $attributes = [];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'data' =>  '' ,
			'hora_inicial' =>  '' ,
			'hora_final' =>  '' ,
			'numero_aula' =>  '' ,
			'plano_ensino_id' =>  '' ,
			'conteudo_programatico_id' =>  '' ,
			'professor_1_id' =>  '' ,
			'professor_2_id' =>  '' ,
			'professor_3_id' =>  '' ,
			'professor_4_id' =>  '' ,
			'professor_5_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'data' =>  '' ,
			'hora_inicial' =>  '' ,
			'hora_final' =>  '' ,
			'numero_aula' =>  '' ,
			'plano_ensino_id' =>  '' ,
			'conteudo_programatico_id' =>  '' ,
			'professor_1_id' =>  '' ,
			'professor_2_id' =>  '' ,
			'professor_3_id' =>  '' ,
			'professor_4_id' =>  '' ,
			'professor_5_id' =>  '' ,

        ],
   ];

}
