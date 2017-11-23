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
        'pessoa.endereco.cep' => 'CEP',
        'pessoa.outra_escola' => 'Outra Instituição',
        'pessoa.uf_nascimento_id' => 'UF(Documentos)',
        'pessoa.uf_exp' => 'UF(Documentos)',
        'img' => 'Foto'

//        'pessoa.data_exame_nacional_um' => 'serbinario_date_format:"d/m/Y"',
//        'pessoa.nota_exame_nacional_um' => '',
//        'pessoa.data_exame_nacional_dois' => 'serbinario_date_format:"d/m/Y"',
//        'pessoa.nota_exame_nacional_dois' => '',
//        'pessoa.enderecos_id' => 'integer',
//        'pessoa.turnos_id' => 'integer',
//        'pessoa.grau_instrucoes_id' => 'integer',
//        'pessoa.profissoes_id' => 'integer',
//        'pessoa.religioes_id' => 'integer',
//        'pessoa.estados_civis_id' => 'integer',
//        'pessoa.tipos_sanguinios_id' => 'integer',
//        'pessoa.cores_racas_id' => 'integer',
//        'estados_id' => 'integer',
//        'pessoa.uf_nascimento_id' => 'integer',
//        'pessoa.telefone_fixo' => 'digits_between:9,11|numeric',
//        'pessoa.celular' => 'digits_between:9,11|numeric',
//        'pessoa.celular2' => 'digits_between:9,11|numeric',

    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'path_comprovante_enem' => 'pdf',
            'path_comprovante_endereco' => 'pdf',
            'path_comprovante_ficha19' => 'pdf',
            'img' => 'image|max:800',
            'pessoa.nome' => 'required|max:60|serbinario_alpha_space_especial',
            //'pessoa.cpf' => 'required|max:20|unique:pessoas,cpf',
            'pessoa.nome_pai' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.nome_mae' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.data_nasciemento' => 'required|serbinario_date_format:"d/m/Y"',
            'pessoa.identidade' => 'digits_between:4,11|numeric',
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
            'pessoa.titulo_eleitoral' => 'digits_between:4,13|numeric',
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
            'pessoa.celular' => 'digits_between:9,16',
            'pessoa.celular2' => 'digits_between:9,16',
            'pessoa.deficiencia_auditiva' => 'integer',
            'pessoa.deficiencia_visual' => 'integer',
            'pessoa.deficiencia_fisica' => 'integer',
            'pessoa.deficiencia_outra' => 'integer',

            //Opções de Curso
            'primeira_opcao_curso_id' => 'required|integer',
            'primeira_opcao_turno_id' => 'required|integer',
            'segunda_opcao_curso_id' => 'integer',
            'segunda_opcao_turno_id' => 'integer',
            'terceira_opcao_curso_id' => 'integer',
            'terceira_opcao_turno_id' => 'integer',

            //Tabela Endereço
            'pessoa.endereco.logradouro' => 'serbinario_alpha_space|max:100',
            'pessoa.endereco.numero' => 'numeric|max:99999',
            'pessoa.endereco.complemento' => 'max:100',
            'pessoa.endereco.cep' => 'numeric|max:99999999',
            'pessoa.endereco.bairros_id' => 'integer',

            //Notas ficha 19
            'pessoa.ficha_nota_portugues' => 'numeric',
            'pessoa.ficha_nota_matematica' => 'numeric',
            'pessoa.ficha_nota_historia' => 'numeric',
            'pessoa.ficha_nota_geografia' => 'numeric',
            'pessoa.ficha_nota_sociologia' => 'numeric',
            'pessoa.ficha_nota_filosofia' => 'numeric',
            'pessoa.ficha_nota_biologia' => 'numeric',
            'pessoa.ficha_nota_lingua_estrangeira' => 'numeric',
            'pessoa.ficha_nota_quimica' => 'numeric',
            'pessoa.ficha_nota_fisica' => 'numeric',

            //Notas ENEM
            'pessoa.nota_humanas' => 'numeric',
            'pessoa.nota_matematica' => 'numeric',
            'pessoa.nota_natureza' => 'numeric',
            'pessoa.nota_linguagem' => 'numeric',
            'pessoa.nota_redacao' => 'numeric',

        ],
        ValidatorInterface::RULE_UPDATE => [
            'path_comprovante_enem' => 'pdf',
            'path_comprovante_endereco' => 'pdf',
            'path_comprovante_ficha19' => 'pdf',
            'img' => 'image|max:800',
            'pessoa.nome' => 'required|max:60|serbinario_alpha_space_especial',
            //'pessoa.cpf' => 'max:20|unique:pessoas,cpf,:cpf',
            'pessoa.nome_pai' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.nome_mae' => 'max:60|serbinario_alpha_space_especial',
            'pessoa.data_nasciemento' => 'required|serbinario_date_format:"d/m/Y"',
            'pessoa.identidade' => 'digits_between:4,11|numeric',
            //'pessoa.nome_social' => 'max:200|serbinario_alpha_space',
            'vestibular_id' => 'integer',
            'pessoa.orgao_rg' => 'max:30',
            'pessoa.data_expedicao' => 'serbinario_date_format:"d/m/Y"',
            'pessoa.titulo_eleitoral' => 'digits_between:4,13|numeric',
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
            'estados_id' => 'integer',
            'pessoa.exames1_id' => 'integer',
            'pessoa.exames2_id' => 'integer',
            'pessoa.uf_nascimento_id' => 'integer',
            'pessoa.uf_exp' => '',
           // 'pessoa.email' => 'email|max:50|unique:pessoas,email,:email',
            'pessoa.telefone_fixo' => 'digits_between:9,11|numeric',
            'pessoa.celular' => '',
            'pessoa.celular2' => '',
            'pessoa.deficiencia_auditiva' => '',
            'pessoa.deficiencia_visual' => '',
            'pessoa.deficiencia_fisica' => '',
            'pessoa.deficiencia_outra' => '',

            //Opções de Curso
            'primeira_opcao_curso_id' => 'integer',
            'primeira_opcao_turno_id' => 'integer',
            'segunda_opcao_curso_id' => 'integer',
            'segunda_opcao_turno_id' => 'integer',
            'terceira_opcao_curso_id' => 'integer',
            'terceira_opcao_turno_id' => 'integer',

            //Endereço
            'pessoa.endereco.logradouro' => 'serbinario_alpha_space|max:100',
            'pessoa.endereco.numero' => 'numeric|max:99999',
            'pessoa.endereco.complemento' => 'max:100',
            'pessoa.endereco.cep' => 'numeric|max:99999999',
            'pessoa.endereco.bairros_id' => 'integer',

            //Notas ficha 19
            'pessoa.ficha_nota_portugues' => 'numeric',
            'pessoa.ficha_nota_matematica' => 'numeric',
            'pessoa.ficha_nota_historia' => 'numeric',
            'pessoa.ficha_nota_geografia' => 'numeric',
            'pessoa.ficha_nota_sociologia' => 'numeric',
            'pessoa.ficha_nota_filosofia' => 'numeric',
            'pessoa.ficha_nota_biologia' => 'numeric',
            'pessoa.ficha_nota_lingua_estrangeira' => 'numeric',
            'pessoa.ficha_nota_quimica' => 'numeric',
            'pessoa.ficha_nota_fisica' => 'numeric',

            //Notas ENEM
            'pessoa.nota_humanas' => 'numeric',
            'pessoa.nota_matematica' => 'numeric',
            'pessoa.nota_natureza' => 'numeric',
            'pessoa.nota_linguagem' => 'numeric',
            'pessoa.nota_redacao' => 'numeric',
        ],
    ];



}