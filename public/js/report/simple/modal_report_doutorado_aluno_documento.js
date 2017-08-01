// carregando todos os cammes preenchidos
function runSimpleReportDouAlunoDocumento()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Doutorado\\Curso|ativo,1',
            'Doutorado\\Turma|doutorado'
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
            builderFilterDouAlunoGeral(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterDouAlunoGeral (dados) {
    //Limpando os cammes
    $('#curso_mes_aluno_documento_id option').find('option').prop('selected', false);
    $('#turma_mes_aluno_documento_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlCurso  = "<option value=''>Selecione um Curso</option>";
    var htmlTurma  = "<option value=''>Selecione uma Turma</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['doutorado\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['doutorado\\curso'][i].id + "'>" + dados['doutorado\\curso'][i].nome + "</option>";
    }

    // Percorrendo o array de turma
    for (var i = 0; i < dados['doutorado\\turma'].length; i++) {
        htmlTurma += "<option value='" + dados['doutorado\\turma'][i].id + "'>" + dados['doutorado\\turma'][i].nome + "</option>";
    }    

    // carregando o html
    $("#curso_dou_aluno_documento_id option").remove();
    $("#curso_dou_aluno_documento_id").append(htmlCurso);
    $("#turma_dou_aluno_documento_id option").remove();
    $("#turma_dou_aluno_documento_id").append(htmlTurma);
    
    // Abrindo o modal
    $("#modal-report-dou-aluno-documento").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportDouAlunoDocumento').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_dou_aluno_documento_id').val();
    var turmaId  = $('#turma_dou_aluno_documento_id').val();

    // Validando as entradas
    if(!cursoId || !turmaId) {
        swal('Todos os campos dos filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId, '_blank');
});