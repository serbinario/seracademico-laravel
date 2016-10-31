<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class TurmaValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $messages   = [];

	protected $attributes = [];

    protected $rules      = [
        ValidatorInterface::RULE_CREATE => [

			'curriculo_id' => 'required|integer',
			'codigo' => 'required|max:15',
			'turno_id' => 'integer',
			'sigla' => '',
			//'descricao' => 'required|max:200',
			//'codigo' => 'required|max:15|unique:fac_turmas,codigo',
			'matricula_inicio' => 'serbinario_date_format:"d/m/Y"',
			'matricula_fim' => 'serbinario_date_format:"d/m/Y"',
			'aula_inicio' => 'serbinario_date_format:"d/m/Y"',
			'aula_final' => 'serbinario_date_format:"d/m/Y"',
			'maximo_vagas' => 'digits_between:0,3|numeric',

        ],
        ValidatorInterface::RULE_UPDATE => [
			'curriculo_id' => 'required|integer',
			'codigo' => 'required|max:15',
			'turno_id' => 'integer',
			'sigla' => '',
			//'descricao' => 'required|max:200',
			//'codigo' => 'required|max:15|unique:fac_turmas,codigo,:id',
			'matricula_inicio' => 'serbinario_date_format:"d/m/Y"',
			'matricula_fim' => 'serbinario_date_format:"d/m/Y"',
			'aula_inicio' => 'serbinario_date_format:"d/m/Y"',
			'aula_final' => 'serbinario_date_format:"d/m/Y"',
			'qtd_parcelas' => 'digits_between:0,3|numeric',
			'maximo_vagas' => 'digits_between:0,3|numeric',

		],
   ];

}
