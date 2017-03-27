// carregando todos os campos preenchidos
function runSimpleReportPosAlunoTurma()
{
    builderFilterPosAlunoTurma();
};

// Função a montar o html
function builderFilterPosAlunoTurma () {
    // Abindo o modal
    $("#modal-report-pos-aluno-turma").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportPosAlunoTurma').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var turmaId  = $('#turma_pos_aluno_turma_id').val();

    // Validando as entradas
    if(!turmaId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_turmas,id="+turmaId, '_blank');
});

//consulta via select2
$("#turma_pos_aluno_turma_id").select2({
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