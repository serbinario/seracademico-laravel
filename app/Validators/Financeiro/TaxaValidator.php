<?php

namespace Seracademico\Validators\Financeiro;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class TaxaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [
    ];

    protected $attributes = [
        'codigo' => 'Código',
        'nome' => 'Nome',
        'dia_vencimento' => 'Dia de Vencimento',
        'valor' =>  'Valor',
        'valido_incio' =>  'Válido Incio' ,
        'valido_fim' =>  'Válido Fim' ,
        'valor_multa' =>  'Valor Multa' ,
        'valor_juros' =>  'Valor Juros' ,
    ];


    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
            'codigo' =>  'required|serbinario_alpha_space_especial|unique:fin_taxas,codigo,:id|max:6', //unique
			'nome' =>  'required|serbinario_alpha_space_especial|max:60',
            'valor' =>  'required|regex:/^\d{0,6}(\.\d{2})?$/', //$
            'tipo_taxa_id' =>  'required|integer',
            'valido_inicio' =>  'serbinario_date_format:"d/m/Y"',
            'valido_fim' =>  'serbinario_date_format:"d/m/Y"',
            'dia_vencimento' =>  'required|integer',
            //'tipo_debito_id' =>  'required|integer', //campo nao encontrado no formulario
            'banco_id' =>  'integer',
            'tipo_multa_id' =>  'integer',
            'valor_multa' =>  'regex:/^\d{0,6}(\.\d{2})?$/' , //$
            'tipo_juro_id' =>  'integer',
            'valor_juros' =>  'regex:/^\d{0,6}(\.\d{2})?$/' , //$
            'exigencia_financeiro_id' =>  'integer',
            'exigencia_biblioteca_id' =>  'integer',
            'exigencia_evento_id' =>  'integer',
            'exigencia_calendario_id' =>  'integer',
            //'semestre_id' => 'integer', //campo nao encontrado no formulario

        ],
        ValidatorInterface::RULE_UPDATE => [

            'codigo' =>  'required|serbinario_alpha_space_especial|unique:fin_taxas,codigo,:id|max:6', //unique
            'nome' =>  'required|serbinario_alpha_space_especial|max:60',
            'valor' =>  'required|regex:/^\d{0,6}(\.\d{2})?$/', //$
            'tipo_taxa_id' =>  'required|integer',
            'valido_inicio' =>  'serbinario_date_format:"d/m/Y"',
            'valido_fim' =>  'serbinario_date_format:"d/m/Y"',
            'dia_vencimento' =>  'required|integer',
            //'tipo_debito_id' =>  'required|integer',
            'banco_id' =>  'integer',
            'tipo_multa_id' =>  'integer',
            'valor_multa' =>  'regex:/^\d{0,6}(\.\d{2})?$/' , //$
            'tipo_juro_id' =>  'integer',
            'valor_juros' =>  'regex:/^\d{0,6}(\.\d{2})?$/' , //$
            'exigencia_financeiro_id' =>  'integer',
            'exigencia_biblioteca_id' =>  'integer',
            'exigencia_evento_id' =>  'integer',
            'exigencia_calendario_id' =>  'integer',
            //'semestre_id' => 'integer', //campo nao encontrado no formulario

        ],
   ];

}