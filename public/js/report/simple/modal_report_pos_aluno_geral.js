// carregando todos os campos preenchidos
function runSimpleReportPosAlunoGeral()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'PosGraduacao\\Curso',
            'PosGraduacao\\Turma|posGraduacao',
            'Turno'
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
            builderFilterPosAlunoGeral(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterPosAlunoGeral (dados) {
    //Limpando os campos
    $('#curso_pos_aluno_geral_id option').find('option').prop('selected', false);
    $('#turma_pos_aluno_geral_id option').find('option').prop('selected', false);
    $('#turno_pos_aluno_geral_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlCurso  = "<option value=''>Selecione um Curso</option>";
    var htmlTurma  = "<option value=''>Selecione uma Turma</option>";
    var htmlTurno  = "<option value=''>Selecione um Turno</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['posgraduacao\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['posgraduacao\\curso'][i].id + "'>" + dados['posgraduacao\\curso'][i].nome + "</option>";
    }

    // Percorrendo o array de turma
    for (var i = 0; i < dados['posgraduacao\\turma'].length; i++) {
        htmlTurma += "<option value='" + dados['posgraduacao\\turma'][i].id + "'>" + dados['posgraduacao\\turma'][i].nome + "</option>";
    }

    // Percorrendo o array de turno
    for (var i = 0; i < dados['turno'].length; i++) {
        htmlTurno += "<option value='" + dados['turno'][i].id + "'>" + dados['turno'][i].nome + "</option>";
    }

    // carregando o html
    $("#curso_pos_aluno_geral_id option").remove();
    $("#curso_pos_aluno_geral_id").append(htmlCurso);
    $("#turma_pos_aluno_geral_id option").remove();
    $("#turma_pos_aluno_geral_id").append(htmlTurma);
    $("#turno_pos_aluno_geral_id option").remove();
    $("#turno_pos_aluno_geral_id").append(htmlTurno);

    // Abrindo o modal
    $("#modal-report-pos-aluno-geral").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportPosAlunoGeral').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_pos_aluno_geral_id').val();
    var turmaId  = $('#turma_pos_aluno_geral_id').val();
    var turnoId  = $('#turno_pos_aluno_geral_id').val();

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId+"&fac_turnos,id="+turnoId, '_blank');
});