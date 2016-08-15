<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class VestibularValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

	protected $messages   = [
		'qtd_vagas' =>  'QTD Vagas' ,
	];

	protected $attributes = [
		'qtd_vagas' =>  'QTD Vagas' ,

	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

			'nome' =>  'required|max:60|unique:fac_vestibulares,nome',
			'codigo' =>  'required|max:8|serbinario_alpha_space_especial|unique:fac_vestibulares,codigo',
			'semestre_id' => 'required|integer',
			'hora_inicial' =>  '' ,
			'hora_final' =>  '' ,
			'qtd_vagas' =>  '' ,
			'instrucoes_boleto' =>  '' ,
			'confirmacao_inscricao' =>  '' ,
			//'banco_id' =>  'integer' ,
			'taxa_id' =>  'required|integer' ,
			'tipo_vencimento_id' =>  'integer' ,
			//'qtd_dias' =>  'integer' ,
			'data_prova' =>  'serbinario_date_format:"d/m/Y"' ,

        ],
        ValidatorInterface::RULE_UPDATE => [

			'nome' =>  'required|max:60|unique:fac_vestibulares,nome,:id',
			'codigo' =>  'required|max:8|serbinario_alpha_space_especial|unique:fac_vestibulares,codigo,:id',
			'semestre_id' => 'required|integer',
			'hora_final' =>  'max:8' ,
			'hora_final' =>  '' ,
			'qtd_vagas' =>  'max:4' ,
			'instrucoes_boleto' =>  '' ,
			'confirmacao_inscricao' =>  '' ,
			//'banco_id' =>  'integer' ,
			'taxa_id' =>  'required|integer' ,
			'tipo_vencimento_id' =>  'integer' ,
			//'qtd_dias' =>  'integer' ,
			'data_prova' =>  'serbinario_date_format:"d/m/Y"' ,

        ],
   ];

}
