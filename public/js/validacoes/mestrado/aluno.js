// Regras de validação
$(document).ready(function () {

    /*ALUNO
    * 'matricula',
     'data_inscricao',
     'pessoa_id',
     'turno_id',
     'path_image',
     'curso_pretendido_1_id',
     'curso_pretendido_2_id',
     'curso_pretendido_3_id',
     'obs_cursos_pretendidos',
     'canal_captacao_id',
     'tipo_pretensao_id',
     'tipo_img',
     'data_contrato',
     'data_matricula',
     'titulo',
     'nota_final',
     'defesa',
     'media',
     'media_conceito',
     'defendeu',
     'professor_orientador_id',
     'professor_banca_1_id',
     'professor_banca_2_id',
     'professor_banca_3_id',
     'professor_banca_4_id',
     'inst_ensino_banca_1_id',
     'inst_ensino_banca_2_id',
     'inst_ensino_banca_3_id',
     'inst_ensino_banca_4_id',
     'data_conclusao',
     'data_colacao',
     'tipo_aluno_id',
     'curriculo_doc_obrigatorio',
     'carta_intencao_doc_obrigatorio',
     'termo_biblioteca',
     'curso_superior_id',
     'curso_pos_graduacao_id',
     'fac_instituicao_id',
     'password',
     'login'
    * */
    /*PESSOA
    * 'nome',
     'email',
     'telefone_fixo',
     'celular',
     'celular2',
     'nome_pai',
     'nome_social',
     'nome_mae',
     'identidade',
     'orgao_rg',
     'uf_exp',
     'data_expedicao',
     'cpf',
     'titulo_eleitoral',
     'zona',
     'secao',
     'resevista',
     'catagoria_resevista',
     'data_nasciemento',
     'nacionalidade',
     'naturalidade',
     'ano_conclusao_superior',
     'outra_instituicao',
     'data_exame_nacional_um',
     'nota_exame_nacional_um',
     'data_exame_nacional_dois',
     'nota_exame_nacional_dois',
     'enderecos_id',
     'sexos_id',
     'turnos_id',
     'grau_instrucoes_id',
     'profissoes_id',
     'religioes_id',
     'estados_civis_id',
     'tipos_sanguinios_id',
     'cores_racas_id',
     'exames1_id',
     'exames2_id',
     'uf_nascimento_id',
     'deficiencia_fisica',
     'deficiencia_auditiva',
     'deficiencia_visual',
     'deficiencia_outra',
     'instituicoes_id',
     'cursos_superiores_id',
     'ano_conclusao_superior',
     'tipo_nivel_sistema_id',
     'rg_doc_obrigatorio',
     'cpf_doc_obrigatorio',
     'certidao_nasc_cas_doc_obrigatorio',
     'titulo_eleitor_doc_obrigatorio',
     'reservista_doc_obrigatorio',
     'diploma_doc_obrigatorio',
     'fotos_3x4_doc_obrigatorio',
     'comp_residencia_doc_obrigatorio',
     'histo_gradu_autentic_obrigatorio',
     'ativo',
     'instituicao_escolar_id',
     'ano_conclusao_medio',
     'outra_escola'
    * */

    $("#formAluno").validate({
        rules: {
            'pessoa[nome]': {
                required: true,
                maxlength: 200
            },

            'pessoa[data_nasciemento]': {
                required: true,
                //dateBr: true,
                maxlength: 10
            },

            'pessoa[cpf]': {
                required: true,
                //cpfBR: true
            },

            /*data_matricula: {
                required: true
            },*/

            'pessoa[email]': {
                email: true,
                maxlength: 100
            },

            'pessoa[telefone_fixo]': {
                maxlength: 15
            },

            'pessoa[celular]': {
                maxlength: 16
            },

            'pessoa[celular2]': {
                maxlength: 16
            },

            'pessoa[nome_pai]': {
                maxlength: 200
            },

            'pessoa[nome_mae]': {
                maxlength: 200
            },

            'pessoa[identidade]': {
                required: true,
                number: true,
                maxlength: 10
            },

            'pessoa[orgao_rg]': {
                maxlength: 10
                //alphaSpace: true
            },

            'pessoa[uf_exp]': {
                maxlength: 2,
                alphaSpace: true
            },

            'pessoa[data_expedicao]': {
                //dateBr: true,
                maxlength: 10
            },

            'pessoa[titulo_eleitoral]': {
                number: true,
                maxlength: 15
            },

            'pessoa[zona]': {
                number: true,
                maxlength: 5
            },

            'pessoa[secao]': {
                number: true,
                maxlength: 5
            },

            'pessoa[resevista]': {
                number: true,
                maxlength: 8
            },

            'pessoa[catagoria_resevista]': {
                maxlength: 2
            },

            'pessoa[nacionalidade]': {
                alphaSpace: true,
                maxlength: 80
            },

            'pessoa[naturalidade]': {
                alphaSpace: true,
                maxlength: 80
            },

            'pessoa[ano_conclusao_superior]': {
                //dateBr: true,
                maxlength: 10
            },

            'pessoa[data_exame_nacional_um]': {
                //dateBr: true,
                maxlength: 10
            },

            'pessoa[sexos_id]': {
                integer: true
            },

            'pessoa[grau_instrucoes_id]': {
                integer: true
            },

            'pessoa[profissoes_id]': {
                integer: true
            },

            'pessoa[estados_civis_id]': {
                integer: true
            },

            'pessoa[tipos_sanguinios_id]': {
                integer: true
            },

            'pessoa[cores_racas_id]': {
                integer: true
            },

            'pessoa[uf_nascimento_id]': {
                integer: true
            },

            'pessoa[deficiencia_fisica]': {
                integer: true
            },

            'pessoa[deficiencia_auditiva]': {
                integer: true
            },

            'pessoa[deficiencia_visual]': {
                integer: true
            },

            'pessoa[deficiencia_outra]': {
                integer: true
            },

            'pessoa[cursos_superiores_id]': {
                integer: true
            },

            'pessoa[rg_doc_obrigatorio]': {
                integer: true
            },

            'pessoa[cpf_doc_obrigatorio]': {
                integer: true
            },

            'pessoa[certidao_nasc_cas_doc_obrigatorio]': {
                integer: true
            },

            'pessoa[titulo_eleitor_doc_obrigatorio]': {
                integer: true
            },

            'pessoa[reservista_doc_obrigatorio]': {
                integer: true
            },

            'pessoa[diploma_doc_obrigatorio]': {
                integer: true
            },

            'pessoa[fotos_3x4_doc_obrigatorio]': {
                integer: true
            },

            'pessoa[comp_residencia_doc_obrigatorio]': {
                integer: true
            },

            'pessoa[histo_gradu_autentic_obrigatorio]': {
                integer: true
            },

            'pessoa[instituicao_escolar_id]': {
                integer: true
            },

            /*'pessoa[ano_conclusao_medio]': {
                dateBr: true,
                maxlength: 10
            },*/

            /*'pessoa[outra_escola]': {
                dateBr: true,
                maxlength: 10
            },*/

            matricula: {
                number: true,
                maxlength: 15
            },

            turno_id: {
                integer: true
            },

            /*path_image: {
                maxlength: 10
            },*/

            titulo: {
                maxlength: 80
            },

            nota_final: {
                decimal: true,
                maxlength: 5
            },

            defesa: {
                maxlength: 100
            },

            media: {
                decimal: true,
                maxlength: 5
            },

            media_conceito: {
                integer: true
            },

            defendeu: {
                integer: true
            },

            professor_orientador_id: {
                integer: true
            },

            professor_banca_1_id: {
                integer: true
            },

            professor_banca_2_id: {
                integer: true
            },

            professor_banca_3_id: {
                integer: true
            },

            professor_banca_4_id: {
                integer: true
            },

            inst_ensino_banca_1_id: {
                integer: true
            },

            inst_ensino_banca_2_id: {
                integer: true
            },

            inst_ensino_banca_3_id: {
                integer: true
            },

            inst_ensino_banca_4_id: {
                integer: true
            },

            data_conclusao: {
                //dateBr: true,
                maxlength: 10
            },

            data_colacao: {
                //dateBr: true,
                maxlength: 10
            },

            password: {
                maxlength: 80
            },

            curso_id: {
                required: true,
                integer: true
            },

            turma_id: {
                required: true,
                integer: true
            },

            sede_id: {
                required: true,
                integer: true
            }
        },
        //For custom messages
        /*messages: {
            nome_operadores:{
                required: "Enter a username",
                minlength: "Enter at least 5 characters"
            }
        },*/
        //Define qual elemento será adicionado
        errorElement : 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },

        highlight: function(element, errorClass) {
            //console.log(errorClass);
            $(element).parent().parent().addClass("has-error");
        },

        unhighlight: function(element, errorClass, validClass) {
            //console.log("Sucess");
            $(element).parent().parent().removeClass("has-error");
        },

        invalidHandler: function(error, validator) {
            var errors = validator.numberOfInvalids();

            if (errors > 0){
                swal(
                    'Existem campos com preenchimento incorreto',
                    'Click em OK para continuar',
                    'error'
                );
            }
        }
    });
});