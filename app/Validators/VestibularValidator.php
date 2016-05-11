<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class VestibularValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

			'nome' =>  'required|max:200|unique:vestibulares,nome',
			'codigo' =>  'required|max:15|unique:vestibulares,codigo',
			'data_inicial' =>  '' ,
			'data_final' =>  '' ,
			'hora_inicial' =>  '' ,
			'hora_final' =>  '' ,
			'qtd_vagas' =>  '' ,
			'instrucoes_boleto' =>  '' ,
			'confirmacao_inscricao' =>  '' ,
			'banco_id' =>  '' ,
			'taxa_id' =>  '' ,
			'tipo_vencimento_id' =>  '' ,
			'qtd_dias' =>  '' ,
			'data_prova' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [

			'nome' =>  'required|max:200|unique:vestibulares,nome,:id',
			'codigo' =>  'required|max:15|unique:vestibulares,codigo,:id',
			'data_inicial' =>  '' ,
			'data_final' =>  '' ,
			'hora_inicial' =>  '' ,
			'hora_final' =>  '' ,
			'qtd_vagas' =>  '' ,
			'instrucoes_boleto' =>  '' ,
			'confirmacao_inscricao' =>  '' ,
			'banco_id' =>  '' ,
			'taxa_id' =>  '' ,
			'tipo_vencimento_id' =>  '' ,
			'qtd_dias' =>  '' ,
			'data_prova' =>  '' ,

        ],
   ];

}
