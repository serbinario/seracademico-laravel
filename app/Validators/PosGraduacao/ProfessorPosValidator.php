<?php

namespace Seracademico\Validators\PosGraduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ProfessorPosValidator extends LaravelValidator
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
		'pessoa.nome' => 'Nome',
		'pessoa.identidade' => 'Identidade(RG)',
		'pessoa.cpf' => 'CPF',
		'pessoa.data_nasciemento' => 'Data de Nascimento',
	];

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
			'pessoa.nome' => 'required|serbinario_alpha_space|max:120',
			'pessoa.data_nasciemento' => 'required|max:15',
			'pessoa.cpf' => 'required|digits_between:3,15',
//			'pessoa.sexos_id' => 'required',
			'pessoa.identidade' => 'required|digits_between:4,12',
		//	'pessoa.endereco.bairros_id' => 'required'
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
			'pessoa.nome' => 'required|serbinario_alpha_space|max:120',
			'pessoa.data_nasciemento' => 'required|max:15',
			'pessoa.cpf' => 'required|digits_between:3,15',
//			'pessoa.sexos_id' => 'required',
			'pessoa.identidade' => 'required|digits_between:4,12',
		//	'pessoa.endereco.bairros_id' => 'required'
		],
   ];

}
