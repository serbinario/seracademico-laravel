<?php

namespace Seracademico\Validators\Financeiro;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class TipoBeneficioValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

	protected $messages   = [];
	protected $attributes = [];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

            'codigo' => 'required|max:8|serbinario_alpha_space_especial|unique:fin_tipos_beneficios,codigo,:id',
			'nome' =>  'required|serbinario_alpha_space_especial|max:60',
			'valido_incio' =>  'serbinario_date_format:"d/m/Y"|max:' ,
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

            'codigo' => 'required|max:8|serbinario_alpha_space_especial|unique:fin_tipos_beneficios,codigo,:id',
			'nome' =>  'required|serbinario_alpha_space_especial|max:60',
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