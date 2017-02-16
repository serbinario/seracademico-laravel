<?php

namespace Seracademico\Validators\Mestrado;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class DisciplinaValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $messages = [
		'required' => ':attribute é requerido',
		'max' => ':attribute só pode ter no máximo :max caracteres',
		'serbinario_alpha_space' => ' :attribute deve conter apenas letras e espaços entre palavras',
		'numeric' => ':attribute deve conter apenas números',
		'email' => ':attribute deve seguir esse exemplo: exemplo@dominio.com',
		'digits_between' => ':attribute deve ter entre :min - :max.',
		'cpf_br' => ':attribute deve ser um número de CPF válido',
		'unique' => ':attribute já se encontra cadastrado'
	];

	protected $attributes = [
		'nome' => 'Nome',
		'codigo' => 'Código',
		'carga_horaria' => '',
		'qtd_falta' => 'Quantidade de Faltas',
		'tipo_disciplina_id' => 'Tipo Disciplina'
	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  'required|max:200|unique:fac_disciplinas,nome',
			'codigo' => 'required|max:15|unique:fac_disciplinas,codigo',
			'carga_horaria' => 'required|digits_between:1,5|numeric' ,
			'qtd_falta' =>  'required|numeric' ,
			'tipo_disciplina_id' =>  'integer' ,
			'tipo_avaliacao_id' =>  'integer' ,

        ],
        ValidatorInterface::RULE_UPDATE => [

			'nome' =>  'required|max:200|unique:fac_disciplinas,nome,:id',
			'codigo' => 'required|max:15|unique:fac_disciplinas,codigo,:id',
			'carga_horaria' => 'digits_between:1,5|numeric' ,
			'qtd_falta' =>  'numeric' ,
			'tipo_disciplina_id' =>  'integer' ,
			'tipo_avaliacao_id' =>  'integer' ,
		],
   ];

}
