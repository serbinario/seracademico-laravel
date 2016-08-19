<?php

namespace Seracademico\Validators\Graduacao;

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
        'data_nasciemento' => 'Data Nascimento',
        'zona' => 'Zona',
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

            'matricula' => 'unique:fac_alunos,matricula|digits_between:4,20|numeric',
            'pessoa.nome' => 'required|max:60|serbinario_alpha_space_especial',
            //'pessoa.cpf' => 'required|max:20|unique:pessoas,cpf',
            'pessoa.nome_pai' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.nome_mae' => 'required|max:60|serbinario_alpha_space_especial',
            'pessoa.data_nasciemento' => 'required|serbinario_date_format:"d/m/Y"',
            'pessoa.identidade' => 'required|digits_between:4,11|numeric',
            'pessoa.enderecos_id' => 'integer',
            'pessoa.sexos_id' => 'integer',
            'pessoa.turnos_id' => 'integer',
            'pessoa.grau_instrucoes_id' => 'integer',
            'pessoa.profissoes_id' => 'integer',
            'pessoa.religioes_id' => 'integer',
            'pessoa.estados_civis_id' => 'integer',
            'pessoa.tipos_sanguinios_id' => 'integer',
            'pessoa.cores_racas_id' => 'integer',
            'estados_id' => 'integer',
            'pessoa.exames1_id' => 'integer',
            'pessoa.exames2_id' => 'integer',
            'pessoa.uf_nascimento_id' => 'integer',
            //'pessoa.nome_social' => 'max:200|serbinario_alpha_space',
            'vestibular_id' => 'required|numeric',
            'pessoa.orgao_rg' => 'max:30',
            'pessoa.data_expedicao' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.titulo_eleitoral' => 'digits_between:4,11|numeric',
            'pessoa.zona' => 'digits_between:1,11|numeric',
            'pessoa.secao' => 'digits_between:1,11|numeric',
            'pessoa.resevista' => 'digits_between:4,11|numeric',
            'pessoa.catagoria_resevista' => 'max:20',
            'pessoa.nacionalidade' => 'max:30|serbinario_alpha_space',
            'pessoa.naturalidade' => 'max:30|serbinario_alpha_space',
            'pessoa.ano_conclusao_2_grau' => '',
            'pessoa.outra_escola' => 'max:100|serbinario_alpha_space',
            'pessoa.data_exame_nacional_um' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.nota_exame_nacional_um' => '',
            'pessoa.data_exame_nacional_dois' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.nota_exame_nacional_dois' => '',
            //'pessoa.email' => 'email|max:50|unique:pessoas,email',
            'pessoa.telefone_fixo' => 'digits_between:9,11|numeric',
            'pessoa.celular' => 'digits_between:9,11|numeric',
            'pessoa.celular2' => 'digits_between:9,11|numeric',
            'pessoa.deficiencia_auditiva' => 'integer',
            'pessoa.deficiencia_visual' => 'integer',
            'pessoa.deficiencia_fisica' => 'integer',
            'pessoa.deficiencia_outra' => 'integer',

            //Tabela Endereço
            'pessoa.endereco.logradouro' => 'serbinario_alpha_space|max:100',
            'pessoa.endereco.numero' => 'numeric|max:99999',
            'pessoa.endereco.complemento' => 'max:100',
            'pessoa.endereco.bairros_id' => 'integer',

        ],
        ValidatorInterface::RULE_UPDATE => [

            'matricula' => 'unique:fac_alunos,matricula|digits_between:4,20|numeric',
            'pessoa.nome' => 'required|max:60|serbinario_alpha_space_especial',
            //'pessoa.cpf' => 'required|max:20|unique:pessoas,cpf',
            'pessoa.nome_pai' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.nome_mae' => 'required|max:60|serbinario_alpha_space_especial',
            'pessoa.data_nasciemento' => 'required|serbinario_date_format:"d/m/Y"',
            'pessoa.identidade' => 'required|digits_between:4,11|numeric',
            'pessoa.enderecos_id' => 'integer',
            'pessoa.sexos_id' => 'integer',
            'pessoa.turnos_id' => 'integer',
            'pessoa.grau_instrucoes_id' => 'integer',
            'pessoa.profissoes_id' => 'integer',
            'pessoa.religioes_id' => 'integer',
            'pessoa.estados_civis_id' => 'integer',
            'pessoa.tipos_sanguinios_id' => 'integer',
            'pessoa.cores_racas_id' => 'integer',
            'estados_id' => 'integer',
            'pessoa.exames1_id' => 'integer',
            'pessoa.exames2_id' => 'integer',
            'pessoa.uf_nascimento_id' => 'integer',
            //'pessoa.nome_social' => 'max:200|serbinario_alpha_space',
            'vestibular_id' => 'required|numeric',
            'pessoa.orgao_rg' => 'max:30',
            'pessoa.data_expedicao' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.titulo_eleitoral' => 'digits_between:4,11|numeric',
            'pessoa.zona' => 'digits_between:1,11|numeric',
            'pessoa.secao' => 'digits_between:1,11|numeric',
            'pessoa.resevista' => 'digits_between:4,11|numeric',
            'pessoa.catagoria_resevista' => 'max:20',
            'pessoa.nacionalidade' => 'max:30|serbinario_alpha_space',
            'pessoa.naturalidade' => 'max:30|serbinario_alpha_space',
            'pessoa.ano_conclusao_2_grau' => '',
            'pessoa.outra_escola' => 'max:100|serbinario_alpha_space',
            'pessoa.data_exame_nacional_um' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.nota_exame_nacional_um' => '',
            'pessoa.data_exame_nacional_dois' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.nota_exame_nacional_dois' => '',
            //'pessoa.email' => 'email|max:50|unique:pessoas,email',
            'pessoa.telefone_fixo' => 'digits_between:9,11|numeric',
            'pessoa.celular' => 'digits_between:9,11|numeric',
            'pessoa.celular2' => 'digits_between:9,11|numeric',
            'pessoa.deficiencia_auditiva' => 'integer',
            'pessoa.deficiencia_visual' => 'integer',
            'pessoa.deficiencia_fisica' => 'integer',
            'pessoa.deficiencia_outra' => 'integer',

            //Tabela Endereço
            'pessoa.endereco.logradouro' => 'serbinario_alpha_space|max:100',
            'pessoa.endereco.numero' => 'numeric|max:99999',
            'pessoa.endereco.complemento' => 'max:100',
            'pessoa.endereco.bairros_id' => 'integer',

        ],
    ];



}