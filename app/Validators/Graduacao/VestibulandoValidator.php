<?php

namespace Seracademico\Validators\Graduacao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class VestibulandoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [
    ];

    protected $attributes = [
        'nome' => 'Nome',
        'cpf' => 'CPF',
        'data_nasciemento' => 'Data Nascimento',
        'zona' => 'Zona',
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'path_comprovante_enem' => 'pdf',
            'path_comprovante_endereco' => 'pdf',
            'path_comprovante_ficha19' => 'pdf',
            //'matricula' => 'unique:fac_alunos,matricula|digits_between:4,20|numeric',
//            'matricula' => '',
//            'nome' => 'required|max:200|serbinario_alpha_space',
//            'nome_pai' => 'required|max:200|serbinario_alpha_space',
//            'nome_social' => 'max:200|serbinario_alpha_space',
//            'nome_mae' => 'required|max:200|serbinario_alpha_space',
//            'identidade' => 'required|digits_between:4,11|numeric',
            'vestibular_id' => 'required|numeric',
//            'orgao_rg' => 'max:30',
//            'data_expedicao' => 'serbinario_date_format:"d/m/Y"',
//            'cpf' => 'max:20|unique:fac_alunos,cpf',
//            'titulo_eleitoral' => 'digits_between:4,11|numeric',
//            'zona' => 'digits_between:1,11|numeric',
//            'secao' => 'digits_between:1,11|numeric',
//            'resevista' => 'digits_between:4,11|numeric',
//            'catagoria_resevista' => 'max:20',
//            'data_nasciemento' => 'required|serbinario_date_format:"d/m/Y"',
//            'nacionalidade' => 'max:30|serbinario_alpha_space',
//            'naturalidade' => 'max:30|serbinario_alpha_space',
//            'ano_conclusao_2_grau' => '',
//            'outra_escola' => 'max:100|serbinario_alpha_space',
//            'data_exame_nacional_um' => 'serbinario_date_format:"d/m/Y"',
//            'nota_exame_nacional_um' => '',
//            'data_exame_nacional_dois' => 'serbinario_date_format:"d/m/Y"',
//            'nota_exame_nacional_dois' => '',
//            'enderecos_id' => 'integer',
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
//            'email' => 'email|max:50|unique:fac_alunos,email',
//            'telefone_fixo' => 'digits_between:9,11|numeric',
//            'celular' => 'digits_between:9,11|numeric',
//            'celular2' => 'digits_between:9,11|numeric',
//            'deficiencia_auditiva' => '',
//            'deficiencia_visual' => '',
//            'deficiencia_fisica' => '',
//            'deficiencia_outra' => '',
//            'fac_instituicoes_id' => '',
//            'fac_cursos_superiores_id' => '',
//            'ano_conclusao_superior' => '',
            'primeira_opcao_curso_id' => 'required|numeric',
            'primeira_opcao_turno_id' => 'required|numeric',

        ],
        ValidatorInterface::RULE_UPDATE => [
            'path_comprovante_enem' => 'pdf',
            'path_comprovante_endereco' => 'pdf',
            'path_comprovante_ficha19' => 'pdf',
            //'matricula' => 'digits_between:4,20|numeric|unique:fac_alunos,matricula,:id',
//            'matricula' => '',
//            'nome' => 'required|max:200|serbinario_alpha_space',
//            'nome_pai' => 'required|max:200|serbinario_alpha_space',
//            'nome_social' => 'max:200|serbinario_alpha_space',
//            'nome_mae' => 'required|max:200|serbinario_alpha_space',
//            'identidade' => 'required|digits_between:0,11|numeric',
//            'orgao_rg' => 'max:30',
//            'data_expedicao' => 'serbinario_date_format:"d/m/Y"',
//            'cpf' => 'required|max:20|unique:pessoas,cpf,:id',
//            'titulo_eleitoral' => 'digits_between:4,11|numeric',
//            'zona' => 'digits_between:1,11|numeric',
//            'secao' => 'digits_between:1,11|numeric',
//            'resevista' => 'digits_between:4,11|numeric',
//            'catagoria_resevista' => 'max:20',
//            'data_nasciemento' => 'required|serbinario_date_format:"d/m/Y"',
//            'nacionalidade' => 'max:30|serbinario_alpha_space',
//            'naturalidade' => 'max:30|serbinario_alpha_space',
//            'ano_conclusao_2_grau' => 'integer',
//            'outra_escola' => 'max:100',
//            'data_exame_nacional_um' => 'serbinario_date_format:"d/m/Y"',
//            'nota_exame_nacional_um' => 'integer',
//            'data_exame_nacional_dois' => 'serbinario_date_format:"d/m/Y"',
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
//            'email' => 'email|max:50|unique:fac_alunos,email,:id',
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
//            'primeira_opcao_curso_id' => 'required|numeric',
//            'primeira_opcao_turno_id' => 'required|numeric',
        ],
    ];



}