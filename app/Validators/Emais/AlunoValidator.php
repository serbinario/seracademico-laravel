<?php

namespace Seracademico\Validators\Emais;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class AlunoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [
    ];

    protected $attributes = [
        'pessoa.nome' => 'Nome',
        'pessoa.cpf' => 'CPF',
        'pessoa.data_nasciemento' => 'Data de Nascimento',
        'pessoa.email' => 'E-mail',

        'pessoa.endereco.logradouro' => 'Logradouro',
        'pessoa.endereco.numero' => 'Número',
        'pessoa.endereco.complemento' => 'Complemento',
        'pessoa.uf_exp' => 'UF(Documentos)',

    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            /*'pessoa.nome' => 'required|max:60|serbinario_alpha_space_especial',
            'pessoa.cpf' => 'required_if:tipo_pretensao_id,==, ""|max:20|pos_aluno_unique_in_pessoa:cpf,:id',
            'pessoa.data_nasciemento' => 'required_if:tipo_pretensao_id,==, ""|serbinario_date_format:"d/m/Y"',
            'pessoa.enderecos_id' => 'integer',
            'pessoa.sexos_id' => 'integer',*/

            //Tabela Endereço
            /*'pessoa.endereco.logradouro' => 'serbinario_alpha_space|max:100',
            'pessoa.endereco.numero' => 'numeric|max:99999',
            'pessoa.endereco.complemento' => 'max:100',
            'pessoa.endereco.bairros_id' => 'integer',*/

        ],
        ValidatorInterface::RULE_UPDATE => [
           /* 'pessoa.nome' => 'required|max:60|serbinario_alpha_space_especial',
            'pessoa.cpf' => 'required_if:tipo_pretensao_id,==, ""|max:20|pos_aluno_unique_in_pessoa:cpf,:id',
            'pessoa.data_nasciemento' => 'required_if:tipo_pretensao_id,==, ""|serbinario_date_format:"d/m/Y"',
            'pessoa.enderecos_id' => 'integer',
            'pessoa.sexos_id' => 'integer',*/

            //Tabela Endereço
           /* 'pessoa.endereco.logradouro' => 'serbinario_alpha_space|max:100',
            'pessoa.endereco.numero' => 'numeric|max:99999',
            'pessoa.endereco.complemento' => 'max:100',
            'pessoa.endereco.bairros_id' => 'integer',*/
        ],
    ];



}