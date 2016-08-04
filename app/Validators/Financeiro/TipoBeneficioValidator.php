<?php

namespace Seracademico\Validators\Financeiro;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class TipoBeneficioValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'valido_incio' =>  '' ,
			'valido_fim' =>  '' ,
			'data_inicio' =>  '' ,
			'data_fim' =>  '' ,
			'valor' =>  '' ,
			'tipo_id' =>  '' ,
			'incidencia_id' =>  '' ,
			'dia_inicial_id' =>  '' ,
			'dia_final_id' =>  '' ,
			'tipo_dia_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'nome' =>  '' ,
			'valido_incio' =>  '' ,
			'valido_fim' =>  '' ,
			'data_inicio' =>  '' ,
			'data_fim' =>  '' ,
			'valor' =>  '' ,
			'tipo_id' =>  '' ,
			'incidencia_id' =>  '' ,
			'dia_inicial_id' =>  '' ,
			'dia_final_id' =>  '' ,
			'tipo_dia_id' =>  '' ,

        ],
   ];

}
