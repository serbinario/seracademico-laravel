// carregando todos os campos preenchidos
function runSimpleReportPosTurmaAtaAniversariante()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'PosGraduacao\\Curso|ativo,1',
            'PosGraduacao\\Turma|posGraduacao',
            'PosGraduacao\\Disciplina|posGraduacao'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/report/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderFilterGraTurmaAtaDeAniversariante(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterGraTurmaAtaDeAniversariante (dados) {
    // //Limpando os campos
    // $('#curso_gra_turma_ata_assinatura_id option').find('option').prop('selected', false);
    // $('#turma_gra_turma_ata_assinatura_id option').find('option').prop('selected', false);
    // $('#disciplina_gra_turma_ata_assinatura_id option').find('option').prop('selected', false);
    //
    // // Variáveis que armazenaram o html
    // var htmlCurso  = "<option value=''>Selecione um Curso</option>";
    // var htmlTurma  = "<option value=''>Selecione uma Turma</option>";
    // var htmlDisciplina = "<option value=''>Selecione uma Disciplina</option>";
    //
    // // Percorrendo o array de Curso
    // for (var i = 0; i < dados['posgraduacao\\curso'].length; i++) {
    //     htmlCurso += "<option value='" + dados['posgraduacao\\curso'][i].id + "'>" + dados['posgraduacao\\curso'][i].nome + "</option>";
    // }
    //
    // // Percorrendo o array de turma
    // for (var i = 0; i < dados['posgraduacao\\turma'].length; i++) {
    //     htmlTurma += "<option value='" + dados['posgraduacao\\turma'][i].id + "'>" + dados['posgraduacao\\turma'][i].nome + "</option>";
    // }
    //
    // // Percorrendo o array de turno
    // for (var i = 0; i < dados['posgraduacao\\disciplina'].length; i++) {
    //     htmlDisciplina += "<option value='" + dados['posgraduacao\\disciplina'][i].id + "'>" + dados['posgraduacao\\disciplina'][i].nome + "</option>";
    // }
    //
    // // carregando o html
    // $("#curso_pos_turma_ata_aniversariante_id option").remove();
    // $("#curso_pos_turma_ata_aniversariante_id").append(htmlCurso);
    // $("#turma_pos_turma_ata_aniversariante_id option").remove();
    // $("#turma_pos_turma_ata_aniversariante_id").append(htmlTurma);
    // $("#disciplina_pos_turma_ata_aniversariante_id option").remove();
    // $("#disciplina_pos_turma_ata_aniversariante_id").append(htmlDisciplina);

    // Abrindo o modal
    $("#modal-report-pos-turma-ata-aniversariante").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportPosTurmaAtaAniversariante').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_pos_turma_ata_aniversariante_id').val();
    var turmaId  = $('#turma_pos_turma_ata_aniversariante_id').val();
    var disciplinaId   = $('#disciplina_pos_turma_ata_aniversariante_id').val();
    var mesAniversario = $('#mes_aniversario_pos_turma_ata_aniversariante').val();

    // Validando as entradas
    if(!cursoId || !turmaId || !disciplinaId || !mesAniversario) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId+"&fac_disciplinas,id="+disciplinaId+"&MONTH(pessoas,data_nasciemento)=" + mesAniversario, '_blank');
});

// selects 2
//consulta via select2
$("#curso_pos_turma_ata_aniversariante_id").select2({
    placeholder: 'Selecione uma curso',
    width: 250,
    allowClear: true,
    ajax: {
        type: 'POST',
        url: "/index.php/seracademico/util/select2",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search':     params.term, // search term
                'tableName':  'fac_cursos',
                'fieldName':  'nome',
                'fieldWhere':  'tipo_nivel_sistema_id',
                'valueWhere':  '2',
                'page':       params.page || 1
            };
        },
        headers: {
            'X-CSRF-TOKEN' : '{{  csrf_token() }}'
        },
        processResults: function (data, params) {

            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.data,
                pagination: {
                    more: data.more
                }
            };
        }
    }
});

//consulta via select2
$("#turma_pos_turma_ata_aniversariante_id").select2({
    placeholder: 'Selecione uma turma',
    width: 250,
    allowClear: true,
    ajax: {
        type: 'POST',
        url: "/index.php/seracademico/util/select2",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search':     params.term, // search term
                'tableName':  'fac_turmas',
                'fieldName':  'codigo',
                'fieldWhere':  'tipo_nivel_sistema_id',
                'valueWhere':  '2',
                'page':       params.page || 1
            };
        },
        processResults: function (data, params) {

            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.data,
                pagination: {
                    more: data.more
                }
            };
        }
    }
});

//consulta via select2
$("#disciplina_pos_turma_ata_aniversariante_id").select2({
    placeholder: 'Selecione uma disciplina',
    width: 250,
    allowClear: true,
    ajax: {
        type: 'POST',
        url: "/index.php/seracademico/util/select2",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search':     params.term, // search term
                'tableName':  'fac_disciplinas',
                'fieldName':  'nome',
                'fieldWhere':  'tipo_nivel_sistema_id',
                'valueWhere':  '2',
                'page':       params.page || 1
            };
        },
        processResults: function (data, params) {

            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.data,
                pagination: {
                    more: data.more
                }
            };
        }
    }
});