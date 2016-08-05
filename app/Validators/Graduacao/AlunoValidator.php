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
            'pessoa.nome' => 'required|serbinario_alpha_space',
            'pessoa.data_nasciemento' => 'required|serbinario_date_format:"d/m/Y"',
            'pessoa.nome_pai' => 'required|max:200|serbinario_alpha_space',
            'pessoa.nome_social' => 'max:200|serbinario_alpha_space',//
            'pessoa.nome_mae' => 'required|max:200|serbinario_alpha_space',
            'pessoa.identidade' => 'required|digits_between:4,11|numeric',
            'pessoa.orgao_rg' => 'max:30',
            'pessoa.data_expedicao' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.cpf' => 'required|max:20|unique:pessoas,cpf',
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
            'pessoa.enderecos_id' => 'integer',
            'pessoa.sexos_id' => 'integer',
            'pessoa.turnos_id' => 'integer',
            'pessoa.grau_instrucoes_id' => 'integer',
            'pessoa.profissoes_id' => 'integer',
            'pessoa.religioes_id' => 'integer',
            'pessoa.estados_civis_id' => 'integer',
            'pessoa.tipos_sanguinios_id' => 'integer',
            'pessoa.cores_racas_id' => 'integer',
            'pessoa.estados_id' => 'integer',
            'pessoa.exames1_id' => 'integer',
            'pessoa.exames2_id' => 'integer',
            'pessoa.uf_nascimento_id' => 'integer',
            'pessoa.email' => 'email|max:50|unique:pessoas,email',
            'pessoa.telefone_fixo' => 'digits_between:9,11|numeric',
            'pessoa.celular' => 'digits_between:9,11|numeric',
            'pessoa.celular2' => 'digits_between:9,11|numeric',
            'pessoa.deficiencia_auditiva' => 'integer',
            'pessoa.deficiencia_visual' => 'integer',
            'pessoa.deficiencia_fisica' => 'integer',
            'pessoa.deficiencia_outra' => 'integer',
            'pessoa.fac_instituicoes_id' => 'integer',
            'pessoa.fac_cursos_superiores_id' => 'integer',
            'pessoa.ano_conclusao_superior' => 'integer',

            //Endereço
            'endereco.logradouro' => '',
            'endereco.cep' => '',
            'endereco.numero' => '',
            'endereco.complemento' => '',

        ],
        ValidatorInterface::RULE_UPDATE => [

//            'matricula' => 'digits_between:4,20|numeric|unique:fac_alunos,matricula,:id',
//            'nome' => 'required|max:200|serbinario_alpha_space',
//            'nome_pai' => 'required|max:200|serbinario_alpha_space',
//            'nome_social' => 'max:200|serbinario_alpha_space',
//            'nome_mae' => 'required|max:200|serbinario_alpha_space',
//            'identidade' => 'required|digits_between:0,11|numeric',
//            'orgao_rg' => 'max:30',
//            'data_expedicao' => 'digits_between:0,10|serbinario_date_format:"d/m/Y"',
//            'cpf' => 'required|numeric|max:20|unique:pessoas,cpf,:id',
//            'titulo_eleitoral' => 'digits_between:4,11|numeric',
//            'zona' => 'digits_between:1,11|numeric',
//            'secao' => 'digits_between:1,11|numeric',
//            'resevista' => 'digits_between:4,11|numeric',
//            'catagoria_resevista' => 'max:20',
//            'data_nasciemento' => 'digits_between:0,10|required|serbinario_date_format:"d/m/Y"',
//            'nacionalidade' => 'max:30|serbinario_alpha_space',
//            'naturalidade' => 'max:30|serbinario_alpha_space',
//            'ano_conclusao_2_grau' => 'integer',
//            'outra_escola' => 'max:100',
//            'data_exame_nacional_um' => 'digits_between:0,10|serbinario_date_format:"d/m/Y"',
//            'nota_exame_nacional_um' => 'integer',
//            'data_exame_nacional_dois' => 'digits_between:0,10|serbinario_date_format:"d/m/Y"',
//            'nota_exame_nacional_dois' => 'integer',
//            'sexos_id' => 'integer',
//            'turnos_id' => 'integer',
//            'grau_instrucoes_id' => 'integer',
//            'profissoes_id' => 'integer',
//            'religioes_id' => 'integer',
//            'estados_civis_id' => 'integer',
//            'tipos_sanguinios_id' => 'integer',
//            'cores_racas_id' => 'integer',
//            'estados_id' => 'integer',
//            'exames1_id' => 'integer',
//            'exames2_id' => 'integer',
//            'uf_nascimento_id' => 'integer',
//            'email' => 'email|max:50|unique:pessoas,email,:id',
//            'telefone_fixo' => 'digits_between:9,11|numeric',
//            'celular' => 'digits_between:9,11|numeric',
//            'celular2' => 'digits_between:9,11|numeric',
//            'deficiencia_auditiva' => 'integer',
//            'deficiencia_visual' => 'integer',
//            'deficiencia_fisica' => 'integer',
//            'deficiencia_outra' => 'integer',
//            'fac_instituicoes_id' => 'integer',
//            'fac_cursos_superiores_id' => 'integer',
//            'ano_conclusao_superior' => 'integer',

        ],
    ];



}