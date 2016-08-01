<?php

namespace Seracademico\Validators\Financeiro;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class TaxaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'codigo' =>  'required|unique:fin_taxas,codigo,:id|max:100', //unique
			'nome' =>  'required|serbinario_alpha_space|max:100',
            'valor' =>  'required|regex:/^\d{0,6}(\.\d{2})?$/', //$
            'tipo_taxa_id' =>  'required|integer',
            'valido_inicio' =>  'required|serbinario_date_format:"d/m/Y"',
            'valido_fim' =>  'required|serbinario_date_format:"d/m/Y"',
            'dia_vencimento' =>  'required|integer',
            'tipo_debito_id' =>  'required|integer',
            'banco_id' =>  'required|integer',
            'tipo_multa_id' =>  'required|integer',
            'valor_multa' =>  'required|regex:/^\d{0,6}(\.\d{2})?$/' , //$
            'tipo_juro_id' =>  'required|integer',
            'valor_juros' =>  'required|regex:/^\d{0,6}(\.\d{2})?$/' , //$
            'exigencia_financeiro_id' =>  'integer',
            'exigencia_biblioteca_id' =>  'integer',
            'exigencia_evento_id' =>  'integer',
            'exigencia_calendario_id' =>  'integer',
            'semestre_id' => 'integer', //campo nao encontrado no formulario

        ],
        ValidatorInterface::RULE_UPDATE => [

            'codigo' =>  'required|unique:fin_taxas,codigo,:id|max:100', //unique
            'nome' =>  'required|serbinario_alpha_space|max:100',
            'valor' =>  'required|regex:/^\d{0,6}(\.\d{2})?$/', //$
            'tipo_taxa_id' =>  'required|integer',
            'valido_inicio' =>  'required|serbinario_date_format:"d/m/Y"',
            'valido_fim' =>  'required|serbinario_date_format:"d/m/Y"',
            'dia_vencimento' =>  'required|integer',
            'tipo_debito_id' =>  'required|integer',
            'banco_id' =>  'required|integer',
            'tipo_multa_id' =>  'required|integer',
            'valor_multa' =>  'required|regex:/^\d{0,6}(\.\d{2})?$/' , //$
            'tipo_juro_id' =>  'required|integer',
            'valor_juros' =>  'required|regex:/^\d{0,6}(\.\d{2})?$/' , //$
            'exigencia_financeiro_id' =>  'integer',
            'exigencia_biblioteca_id' =>  'integer',
            'exigencia_evento_id' =>  'integer',
            'exigencia_calendario_id' =>  'integer',
            'semestre_id' => 'integer', //campo nao encontrado no formulario

        ],
   ];

}

/*
 * 'nome' => 'required|max:200|serbinario_alpha_space',
// 'nome_pai' => 'required|max:200|serbinario_alpha_space',
// 'nome_social' => 'max:200|serbinario_alpha_space',
// 'nome_mae' => 'required|max:200|serbinario_alpha_space',
// 'identidade' => 'required|digits_between:0,11|numeric',
// 'orgao_rg' => 'max:30',
// 'data_expedicao' => 'serbinario_date_format:"d/m/Y"',
// 'cpf' => 'required|max:20|unique:fac_alunos,cpf,:id',
// 'titulo_eleitoral' => 'digits_between:4,11|numeric',
// 'zona' => 'digits_between:1,11|numeric',
// 'secao' => 'digits_between:1,11|numeric',
// 'resevista' => 'digits_between:4,11|numeric',
// 'catagoria_resevista' => 'max:20',
// 'data_nasciemento' => 'required|serbinario_date_format:"d/m/Y"',
// 'nacionalidade' => 'max:30|serbinario_alpha_space',
// 'naturalidade' => 'max:30|serbinario_alpha_space',
// 'ano_conclusao_2_grau' => 'integer',
// 'outra_escola' => 'max:100',
 */