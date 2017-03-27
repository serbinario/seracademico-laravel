// carregando todos os campos preenchidos
function runSimpleReportMesTurmaAtaFrequencia()
{
    // Definindo os models
    var dados =  {
        'models' : [
            //'PosMesduacao\\Curso|ativo,1',
            //'PosMesduacao\\Turma|posMesduacao',
            //'PosMesduacao\\Disciplina|posMesduacao'
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
            builderFilterMesTurmaAtaDeAssinatura(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterMesTurmaAtaDeAssinatura (dados) {
    // Abrindo o modal
    $("#modal-report-mes-turma-ata-assinatura").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportMesTurmaAtaAssinatura').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_mes_turma_ata_assinatura_id').val();
    var turmaId  = $('#turma_mes_turma_ata_assinatura_id').val();
    var disciplinaId  = $('#disciplina_mes_turma_ata_assinatura_id').val();
    var turno = $('#turno_mes_turma_ata_assinatura_id').val();

    // Validando as entradas
    if(!cursoId || !turmaId || !disciplinaId || !turno) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId+"&fac_disciplinas,id="+disciplinaId+'&turno='+turno,
        '_blank');
});

// selects 2
//consulta via select2
$("#curso_mes_turma_ata_assinatura_id").select2({
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
                'valueWhere':  '3',
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
$("#turma_mes_turma_ata_assinatura_id").select2({
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
                'valueWhere':  '3',
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
$("#disciplina_mes_turma_ata_assinatura_id").select2({
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
                'valueWhere':  '3',
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