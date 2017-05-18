<?php

namespace Seracademico\Validators\Tecnico;

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

			'curriculo_id' => 'integer',
			'turno_id' => 'integer',
			'sigla' => '',
			'valor_turma' => '',
			'valor_disciplina' => '',
			'sala_id' => 'integer',
			'obs_sala' => 'max:1000',
			'codigo' => 'required|max:30|unique:fac_turmas,codigo',
			'matricula_inicio' => 'serbinario_date_format:"d/m/Y"',
			'matricula_fim' => 'serbinario_date_format:"d/m/Y"',
			'aula_inicio' => 'serbinario_date_format:"d/m/Y"',
			'aula_final' => 'serbinario_date_format:"d/m/Y"',
			'qtd_parcelas' => 'digits_between:0,3|numeric',
			'maximo_vagas' => 'digits_between:0,3|numeric',
			'minimo_vagas' => 'digits_between:0,3|numeric',
			'observacao_vagas' => 'max:1000',
			'vencimento_inicial' => 'serbinario_date_format:"d/m/Y"',

        ],
        ValidatorInterface::RULE_UPDATE => [
			'curriculo_id' => 'integer',
			'turno_id' => 'integer',
			'sigla' => '',
			'valor_turma' => '',
			'valor_disciplina' => '',
			'sala_id' => 'integer',
			'obs_sala' => 'max:1000',
			'codigo' => 'required|max:30|unique:fac_turmas,codigo,:id',
			'matricula_inicio' => 'serbinario_date_format:"d/m/Y"',
			'matricula_fim' => 'serbinario_date_format:"d/m/Y"',
			'aula_inicio' => 'serbinario_date_format:"d/m/Y"',
			'aula_final' => 'serbinario_date_format:"d/m/Y"',
			'qtd_parcelas' => 'digits_between:0,3|numeric',
			'maximo_vagas' => 'digits_between:0,3|numeric',
			'minimo_vagas' => 'digits_between:0,3|numeric',
			'observacao_vagas' => 'max:1000',
			'vencimento_inicial' => 'serbinario_date_format:"d/m/Y"',
		],
   ];

}
