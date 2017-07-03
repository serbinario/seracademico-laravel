<?php

namespace Seracademico\Validators\Tecnico;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;
use Seracademico\Providers\Validators\UniqueTecDisciplina;

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
		'unique' => ':attribute já se encontra cadastrado(a)',
		'tec_unique_disciplina' => ':attribute já se encontra cadastrado(a)',
		'tec_unique_codigo' => ':attribute já se encontra cadastrado(a)'
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
            
			'nome' => 'required|max:200|tec_unique_disciplina',
			'codigo' => 'required|max:15|tec_unique_codigo',
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
