// carregando todos os campos preenchidos
function runSimpleReportPosAlunoDocumento()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'PosGraduacao\\Curso',
            'PosGraduacao\\Turma|posGraduacao'
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
    $('#curso_pos_aluno_documento_id option').find('option').prop('selected', false);
    $('#turma_pos_aluno_documento_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlCurso  = "<option value=''>Selecione um Curso</option>";
    var htmlTurma  = "<option value=''>Selecione uma Turma</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['posgraduacao\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['posgraduacao\\curso'][i].id + "'>" + dados['posgraduacao\\curso'][i].nome + "</option>";
    }

    // Percorrendo o array de turma
    for (var i = 0; i < dados['posgraduacao\\turma'].length; i++) {
        htmlTurma += "<option value='" + dados['posgraduacao\\turma'][i].id + "'>" + dados['posgraduacao\\turma'][i].nome + "</option>";
    }    

    // carregando o html
    $("#curso_pos_aluno_documento_id option").remove();
    $("#curso_pos_aluno_documento_id").append(htmlCurso);
    $("#turma_pos_aluno_documento_id option").remove();
    $("#turma_pos_aluno_documento_id").append(htmlTurma);
    
    // Abrindo o modal
    $("#modal-report-pos-aluno-documento").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportPosAlunoDocumento').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_pos_aluno_documento_id').val();
    var turmaId  = $('#turma_pos_aluno_documento_id').val();

    // Validando as entradas
    if(!cursoId || !turmaId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId, '_blank');
});