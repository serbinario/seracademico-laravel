<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class VestibularValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

			'nome' =>  'required|max:200|unique:fac_vestibulares,nome',
			'codigo' =>  'required|max:15|unique:fac_vestibulares,codigo',
			'semestre_id' => 'required|integer',
			'hora_inicial' =>  '' ,
			'hora_final' =>  '' ,
			'qtd_vagas' =>  '' ,
			'instrucoes_boleto' =>  '' ,
			'confirmacao_inscricao' =>  '' ,
			'banco_id' =>  'integer' ,
			'taxa_id' =>  'integer' ,
			'tipo_vencimento_id' =>  'integer' ,
			'qtd_dias' =>  'integer' ,
			'data_prova' =>  'serbinario_date_format:"d/m/Y"' ,

        ],
        ValidatorInterface::RULE_UPDATE => [

			'nome' =>  'required|max:200|unique:fac_vestibulares,nome,:id',
			'codigo' =>  'required|max:15|unique:fac_vestibulares,codigo,:id',
			'semestre_id' => 'required|integer',
			'hora_final' =>  '' ,
			'qtd_vagas' =>  '' ,
			'instrucoes_boleto' =>  '' ,
			'confirmacao_inscricao' =>  '' ,
			'banco_id' =>  'integer' ,
			'taxa_id' =>  'integer' ,
			'tipo_vencimento_id' =>  'integer' ,
			'qtd_dias' =>  'integer' ,
			'data_prova' =>  'serbinario_date_format:"d/m/Y"' ,

        ],
   ];

}
