// carregando todos os cammes preenchidos
function runSimpleReportMesGeralAluno()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Mestrado\\Curso|ativo,1',
            'Mestrado\\Turma|mestrado'
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
            builderFilterMesAlunoGeral(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterMesAlunoGeral (dados) {
    //Limpando os cammes
    $('#curso_mes_aluno_geral_id option').find('option').prop('selected', false);
    $('#turma_mes_aluno_geral_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlCurso  = "<option value=''>Selecione um Curso</option>";
    var htmlTurma  = "<option value=''>Selecione uma Turma</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['mestrado\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['mestrado\\curso'][i].id + "'>" + dados['mestrado\\curso'][i].nome + "</option>";
    }

    // Percorrendo o array de turma
    for (var i = 0; i < dados['mestrado\\turma'].length; i++) {
        htmlTurma += "<option value='" + dados['mestrado\\turma'][i].id + "'>" + dados['mestrado\\turma'][i].nome + "</option>";
    }


    // carregando o html
    $("#curso_mes_aluno_geral_id option").remove();
    $("#curso_mes_aluno_geral_id").append(htmlCurso);
    $("#turma_mes_aluno_geral_id option").remove();
    $("#turma_mes_aluno_geral_id").append(htmlTurma);

    // Abrindo o modal
    $("#modal-report-mes-aluno-geral").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportMesAlunoGeral').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_mes_aluno_geral_id').val();
    var turmaId  = $('#turma_mes_aluno_geral_id').val();

    // Validando as entradas
    if(!cursoId || !turmaId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId, '_blank');
});