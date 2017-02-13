<?php

namespace Seracademico\Validators\Mestrado;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class CursoValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $messages   = [
	];

	protected $attributes = [
		'nome' 		=> 'Nome',
		'codigo' 	=> 'Código'
	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

			'nome' =>  'required|max:200|unique:fac_cursos,nome',
			'codigo' =>  'required|max:30|unique:fac_cursos,codigo',
			'portaria_mec_rec' =>  'max:50',
			'numero_decreto_rec' =>  '' ,
			'data_decreto_rec' =>  'serbinario_date_format:"d/m/Y"',
			'data_dou_rec' =>  'serbinario_date_format:"d/m/Y"',
			'portaria_mec_aut' =>  'max:50',
			'numero_decreto_aut' =>  '' ,
			'data_decreto_aut' =>  'serbinario_date_format:"d/m/Y"',
			'data_dou_aut' =>  'serbinario_date_format:"d/m/Y"',
			'data_matricula_inicio' =>  'serbinario_date_format:"d/m/Y"',
			'data_matricula_fim' =>  'serbinario_date_format:"d/m/Y"',
			'inicio_aula' =>  'serbinario_date_format:"d/m/Y"',
			'fim_aula' =>  'serbinario_date_format:"d/m/Y"',
			'maximo_vagas' =>  'digits_between:0,3|numeric',
			'minumo_vagas' =>  'digits_between:0,3|numeric',
			'obs_vagas' =>  '' ,
			'valor' =>  '' ,
			'parcelas' =>  'digits_between:0,3|numeric',
			'vencimento_inicial' =>  '' ,
			'sede_id' =>  '' ,
			'tipo_curso_id' =>  '' ,
			'cordenador_id' =>  '' ,
			'carga_horaria' => 'required'

        ],
        ValidatorInterface::RULE_UPDATE => [

			'nome' =>  'required|max:200|unique:fac_cursos,nome,:id',
			'codigo' =>  'required|max:30|unique:fac_cursos,codigo,:id',
			'duracao_meses' =>  'digits_between:1,3|numeric',
			'portaria_mec_rec' =>  'max:50',
			'numero_decreto_rec' =>  '' ,
			'data_decreto_rec' =>  'serbinario_date_format:"d/m/Y"',
			'data_dou_rec' =>  'serbinario_date_format:"d/m/Y"',
			'portaria_mec_aut' =>  'max:50',
			'numero_decreto_aut' =>  '' ,
			'data_decreto_aut' =>  'serbinario_date_format:"d/m/Y"',
			'data_dou_aut' =>  'serbinario_date_format:"d/m/Y"',
			'data_matricula_inicio' =>  'serbinario_date_format:"d/m/Y"',
			'data_matricula_fim' =>  'serbinario_date_format:"d/m/Y"',
			'inicio_aula' =>  'serbinario_date_format:"d/m/Y"',
			'fim_aula' =>  'serbinario_date_format:"d/m/Y"',
			'maximo_vagas' =>  'digits_between:0,3|numeric',
			'minumo_vagas' =>  'digits_between:0,3|numeric',
			'obs_vagas' =>  '' ,
			'valor' =>  '' ,
			'parcelas' =>  'digits_between:0,3|numeric',
			'vencimento_inicial' =>  '' ,
			'sede_id' =>  '' ,
			'tipo_curso_id' =>  '' ,
			'cordenador_id' =>  '' ,
			'carga_horaria' => 'required'
		],
   ];

}
