<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ProfessorValidator extends LaravelValidator
{

	use TraitReplaceRulesValidator;
	
	protected $messages = [];

	protected $attributes = [];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
			
			'tratamento' =>  '' ,
			'path_image' =>  '' ,
			'instituicao_graduacao_id' =>  '' ,
			'instituicao_pos_id' =>  '' ,
			'instituicao_mestrado_id' =>  '' ,
			'instituicao_doutorado_id' =>  '' ,
			'especificacao_graduacao' =>  '' ,
			'especificacao_pos' =>  '' ,
			'especificacao_mestrado' =>  '' ,
			'especificacao_doutorado' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
			'tratamento' =>  '' ,
			'path_image' =>  '' ,
			'instituicao_graduacao_id' =>  '' ,
			'instituicao_pos_id' =>  '' ,
			'instituicao_mestrado_id' =>  '' ,
			'instituicao_doutorado_id' =>  '' ,
			'especificacao_graduacao' =>  '' ,
			'especificacao_pos' =>  '' ,
			'especificacao_mestrado' =>  '' ,
			'especificacao_doutorado' =>  '' ,
		],
   ];

}
