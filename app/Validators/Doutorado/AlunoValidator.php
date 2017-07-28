<?php

namespace Seracademico\Validators\Doutorado;

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
        'pessoa.nome_pai' => 'Nome Pai',
        'pessoa.nome_mae' => 'Nome Mãe',
        'pessoa.identidade' => 'Identidade(RG)',
        'pessoa.cpf' => 'CPF',
        'pessoa.data_nasciemento' => 'Data de Nascimento',
        'pessoa.email' => 'E-mail',
        'primeira_opcao_curso_id' => '1ª Opção ',
        'primeira_opcao_turno_id' => '1ª Opção Turno',
        'pessoa.sexos_id' => 'integer',
        'pessoa.deficiencia_auditiva' => 'integer',
        'pessoa.deficiencia_visual' => 'integer',
        'pessoa.deficiencia_fisica' => 'integer',
        'pessoa.deficiencia_outra' => 'integer',
        'pessoa.exames1_id' => 'integer',
        'pessoa.exames2_id' => 'integer',
        'vestibular_id' => 'Vestibular',
        'pessoa.orgao_rg' => 'Orgão RG',
        'pessoa.data_expedicao' => 'Data de Expedição',
        'pessoa.titulo_eleitoral' => 'Título Eleitoral',
        'pessoa.zona' => 'Zona',
        'pessoa.secao' => 'Seção',
        'pessoa.resevista' => 'Reservista',
        'pessoa.catagoria_resevista' => 'Categoria Reservista',
        'pessoa.nacionalidade' => 'Nacionalidade',
        'pessoa.naturalidade' => 'Naturalidade',
        'pessoa.ano_conclusao_2_grau' => 'Ano de Conclusao 2 Grau',
        'pessoa.endereco.logradouro' => 'Logradouro',
        'pessoa.endereco.numero' => 'Número',
        'pessoa.endereco.complemento' => 'Complemento',
        'pessoa.uf_exp' => 'UF(Documentos)',
        'img' => 'Foto',
        'password' => 'Senha (portal do aluno)'
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'img' => 'image|max:800',
            'matricula' => 'unique:pos_alunos,matricula',
            'pessoa.nome' => 'required|max:60|serbinario_alpha_space_especial',
            'pessoa.cpf' => 'required_if:tipo_pretensao_id,==, ""|max:20|pos_aluno_unique_in_pessoa:cpf,:id',
            'pessoa.nome_pai' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.nome_mae' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.data_nasciemento' => 'required_if:tipo_pretensao_id,==, ""|serbinario_date_format:"d/m/Y"',
            'pessoa.identidade' => 'required_if:tipo_pretensao_id,==, ""|digits_between:4,13|numeric',
            'pessoa.enderecos_id' => 'integer',
            'pessoa.sexos_id' => 'integer',
            'pessoa.turnos_id' => 'integer',
            'pessoa.grau_instrucoes_id' => 'integer',
            'pessoa.profissoes_id' => 'integer',
            'pessoa.estados_civis_id' => 'integer',
            'pessoa.tipos_sanguinios_id' => 'integer',
            'pessoa.cores_racas_id' => 'integer',
            'estados_id' => 'integer',
            'pessoa.uf_nascimento_id' => 'integer',
            'pessoa.uf_exp' => '',
            'pessoa.nome_social' => 'max:200|serbinario_alpha_space',
            'pessoa.orgao_rg' => 'max:30',
            'pessoa.data_expedicao' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.titulo_eleitoral' => 'digits_between:4,20|numeric',
            'pessoa.zona' => 'digits_between:1,11|numeric',
            'pessoa.secao' => 'digits_between:1,11|numeric',
            'pessoa.resevista' => 'digits_between:4,11|numeric',
            'pessoa.catagoria_resevista' => 'max:20',
            'pessoa.nacionalidade' => 'max:30|serbinario_alpha_space',
            'pessoa.naturalidade' => 'max:30|serbinario_alpha_space',
            'pessoa.email' => 'email|max:50|pos_aluno_unique_in_pessoa:email,:id',
            'pessoa.telefone_fixo' => 'digits_between:9,11|numeric',
            'pessoa.celular' => 'digits_between:9,11|numeric',
            'pessoa.celular2' => 'digits_between:9,11|numeric',
            'pessoa.deficiencia_auditiva' => 'integer',
            'pessoa.deficiencia_visual' => 'integer',
            'pessoa.deficiencia_fisica' => 'integer',
            'pessoa.deficiencia_outra' => 'integer',
            'curso_id' => 'required',
            'turma_id' => 'required',
            //Tabela Endereço
            'pessoa.endereco.logradouro' => 'serbinario_alpha_space|max:100',
            'pessoa.endereco.numero' => 'numeric|max:99999',
            'pessoa.endereco.complemento' => 'max:100',
            'pessoa.endereco.bairros_id' => 'integer',
            'password' => '',
            'password_confirmation' => 'same:password'

        ],
        ValidatorInterface::RULE_UPDATE => [
            'img' => 'image|max:800',
            'matricula' => 'unique:pos_alunos,matricula,:id',
            'pessoa.nome' => 'required|max:60|serbinario_alpha_space_especial',
            //'pessoa.cpf' => 'required_if:tipo_pretensao_id,==, ""|max:20|pos_aluno_unique_in_pessoa:cpf,:id',
            'pessoa.nome_pai' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.nome_mae' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.data_nasciemento' => 'required_if:tipo_pretensao_id,==, ""|serbinario_date_format:"d/m/Y"',
            'pessoa.identidade' => 'required_if:tipo_pretensao_id,==, ""|digits_between:4,11|numeric',
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
            'pessoa.uf_nascimento_id' => 'integer',
            'pessoa.nome_social' => 'max:200|serbinario_alpha_space',
            'pessoa.orgao_rg' => 'max:30',
            'pessoa.data_expedicao' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.titulo_eleitoral' => 'digits_between:4,20|numeric',
            'pessoa.zona' => 'digits_between:1,11|numeric',
            'pessoa.secao' => 'digits_between:1,11|numeric',
            'pessoa.resevista' => 'digits_between:4,11|numeric',
            'pessoa.catagoria_resevista' => 'max:20',
            'pessoa.nacionalidade' => 'max:30|serbinario_alpha_space',
            'pessoa.naturalidade' => 'max:30|serbinario_alpha_space',
            'pessoa.email' => 'email|max:50', //|pos_aluno_unique_in_pessoa:email,:id
            'pessoa.telefone_fixo' => 'digits_between:9,11|numeric',
            'pessoa.celular' => 'digits_between:9,11|numeric',
            'pessoa.celular2' => 'digits_between:9,11|numeric',
            'pessoa.deficiencia_auditiva' => 'integer',
            'pessoa.deficiencia_visual' => 'integer',
            'pessoa.deficiencia_fisica' => 'integer',
            'pessoa.deficiencia_outra' => 'integer',
            'curso_id' => 'required',
            'turma_id' => 'required',
//            //Tabela Endereço
            'pessoa.endereco.logradouro' => 'serbinario_alpha_space|max:100',
            'pessoa.endereco.numero' => 'numeric|max:99999',
            'pessoa.endereco.complemento' => 'max:100',
            'pessoa.endereco.bairros_id' => 'integer',
            'password' => '',
            'password_confirmation' => 'same:password'
        ],
    ];



}