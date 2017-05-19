<?php

namespace Seracademico\Validators\Tecnico;

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

			'img' => 'image|max:800',
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
			'img' => 'image|max:800',
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
