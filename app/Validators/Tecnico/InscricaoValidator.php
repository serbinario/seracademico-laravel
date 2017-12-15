<?php

namespace Seracademico\Validators\Tecnico;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class InscricaoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

	protected $messages   = [
		'quantidade' =>  'QTD Vagas',
	];

	protected $attributes = [
		'quantidade' =>  'QTD Vagas',

	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

			'nome' =>  'required|max:60|unique:pos_incricoes,nome',
			'codigo' =>  'required|max:8|serbinario_alpha_space_especial|unique:pos_incricoes,codigo',
			'quantidade' =>  '' ,
			'tipo_nivel_sistema_id' =>  'integer' ,

        ],
        ValidatorInterface::RULE_UPDATE => [

            'nome' =>  'required|max:60|unique:pos_incricoes,nome,:id',
            'codigo' =>  'required|max:8|serbinario_alpha_space_especial|unique:pos_incricoes,codigo,:id',
            'quantidade' =>  '' ,
            'tipo_nivel_sistema_id' =>  'integer' ,

        ],
   ];

}
