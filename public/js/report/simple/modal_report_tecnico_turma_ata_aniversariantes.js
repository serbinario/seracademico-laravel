// carregando todos os cammes preenchidos
function runSimpleReportTecTurmaAtaAniversariante()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Tecnico\\Curso|ativo,1',
            'Tecnico\\Turma|Tecnico',
            'Tecnico\\Disciplina|Tecnico'
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
            builderFilterTecTurmaAtaDeAniversariante(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterTecTurmaAtaDeAniversariante (dados) {
    // Abrindo o modal
    $("#modal-report-tec-turma-ata-aniversariante").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportTecTurmaAtaAniversariante').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_tec_turma_ata_aniversariante_id').val();
    var turmaId  = $('#turma_tec_turma_ata_aniversariante_id').val();
    var mesAniversario = $('#mes_aniversario_tec_turma_ata_aniversariante').val();

    // Validando as entradas
    if(!cursoId || !turmaId || !mesAniversario) {
        swal('Todos os cammes do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId+"&MONTH(pessoas,data_nasciemento)=" + mesAniversario, '_blank');
});

// selects 2
//consulta via select2
$("#curso_tec_turma_ata_aniversariante_id").select2({
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
                'valueWhere':  '4',
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
$("#turma_tec_turma_ata_aniversariante_id").select2({
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
                'valueWhere':  '4',
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