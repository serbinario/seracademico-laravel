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

            'codigo' => 'integer|max:20', //'unique:fin_tipos_beneficios, codigo'
			'nome' =>  'serbinario_alpha_space|max:100',
			'valido_incio' =>  'serbinario_date_format:"d/m/Y"|max:10' ,
			'valido_fim' =>  'serbinario_date_format:"d/m/Y"|max:10' ,
			'data_inicio' =>  'serbinario_date_format:"d/m/Y"|max:10' ,
			'data_fim' =>  'serbinario_date_format:"d/m/Y"|max:10' ,
			'valor' =>  'regex:/^\d{0,6}(\.\d{2})?$/' ,
			'tipo_id' =>  'integer' ,
			'incidencia_id' =>  'integer' ,
			'dia_inicial_id' =>  'integer' ,
			'dia_final_id' =>  'integer' ,
			'tipo_dia_id' =>  'integer' ,

        ],
        ValidatorInterface::RULE_UPDATE => [

            'codigo' => 'integer|max:20', //'unique:fin_tipos_beneficios, codigo'
            'nome' =>  'serbinario_alpha_space|max:100',
            'valido_incio' =>  'serbinario_date_format:"d/m/Y"|max:10' ,
            'valido_fim' =>  'serbinario_date_format:"d/m/Y"|max:10' ,
            'data_inicio' =>  'serbinario_date_format:"d/m/Y"|max:10' ,
            'data_fim' =>  'serbinario_date_format:"d/m/Y"|max:10' ,
            'valor' =>  'regex:/^\d{0,6}(\.\d{2})?$/' ,
            'tipo_id' =>  'integer' ,
            'incidencia_id' =>  'integer' ,
            'dia_inicial_id' =>  'integer' ,
            'dia_final_id' =>  'integer' ,
            'tipo_dia_id' =>  'integer' ,

        ],
   ];

}