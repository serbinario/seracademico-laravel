// carregando todos os cammes preenchidos
function runSimpleReportTecGeralAluno()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Tecnico\\Curso|ativo,1',
            'Tecnico\\Turma|tecnico'
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
            builderFilterTecAlunoGeral(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterTecAlunoGeral (dados) {
    //Limpando os cammes
    $('#curso_tecnico_aluno_geral_id option').find('option').prop('selected', false);
    $('#turma_tecnico_aluno_geral_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlCurso  = "<option value=''>Selecione um Curso</option>";
    var htmlTurma  = "<option value=''>Selecione uma Turma</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['tecnico\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['tecnico\\curso'][i].id + "'>" + dados['tecnico\\curso'][i].nome + "</option>";
    }

    // Percorrendo o array de turma
    for (var i = 0; i < dados['tecnico\\turma'].length; i++) {
        htmlTurma += "<option value='" + dados['tecnico\\turma'][i].id + "'>" + dados['tecnico\\turma'][i].nome + "</option>";
    }


    // carregando o html
    $("#curso_tecnico_aluno_geral_id option").remove();
    $("#curso_tecnico_aluno_geral_id").append(htmlCurso);
    $("#turma_tecnico_aluno_geral_id option").remove();
    $("#turma_tecnico_aluno_geral_id").append(htmlTurma);

    // Abrindo o modal
    $("#modal-report-tecnico-aluno-geral").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportTecnicoAlunoGeral').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_tecnico_aluno_geral_id').val();
    var turmaId  = $('#turma_tecnico_aluno_geral_id').val();

    // Validando as entradas
    if(!cursoId || !turmaId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId, '_blank');
});