<?php

namespace Seracademico\Validators\Tecnico;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ModuloValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $messages   = [
	];

	protected $attributes = [
		'nome' => 'Nome',
		'codigo' => 'Código'
	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
			'nome' =>  'required|max:200|unique:tec_modulos,nome',
			'codigo' =>  'required|max:15|unique:tec_modulos,codigo',
        ],

        ValidatorInterface::RULE_UPDATE => [
			'nome' =>  'required|max:200|unique:tec_modulos,nome,:id',
			'codigo' =>  'required|max:15|unique:tec_modulos,codigo,:id',
		],
   ];

}
