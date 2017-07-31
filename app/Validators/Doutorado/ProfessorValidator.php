<?php

namespace Seracademico\Validators\Doutorado;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ProfessorValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;
	
	protected $messages = [
		'serbinario_date_format' => 'O campo :attribute é inválido!',
		'required' => 'O campo :attribute é requerido!'
	];

	protected $attributes = [
		'pessoa.nome' => 'Nome'
	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
			'pessoa.nome' => 'required',
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
