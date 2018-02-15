// carregando todos os campos preenchidos
function runSimpleReportGraAlunoMatriculadoContato()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Turno',
            'Graduacao\\Curso|ativo,1'
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
            builderFilterGraAlunoMatriculadoContatos(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterGraAlunoMatriculadoContatos (dados) {
    //Limpando os campos
    $('#turno_gra_aluno_matriculado_id option').find('option').prop('selected', false);
    $('#curso_gra_aluno_matriculado_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlTurno  = "<option value=''>Selecione um Turno</option>";
    var htmlCurso     = "<option value=''>Selecione um Curso</option>";

    // Percorrendo o array de Semestre
    for (var i = 0; i < dados['turno'].length; i++) {
        htmlTurno += "<option value='" + dados['turno'][i].id + "'>" + dados['turno'][i].nome + "</option>";
    }

    // Percorrendo o array do Curso
    for (var i = 0; i < dados['graduacao\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['graduacao\\curso'][i].id + "'>" + dados['graduacao\\curso'][i].nome + "</option>";
    }

    // carregando o html
    $("#turno_gra_aluno_matriculado_id option").remove();
    $("#turno_gra_aluno_matriculado_id").append(htmlTurno);
    $("#curso_gra_aluno_matriculado_id option").remove();
    $("#curso_gra_aluno_matriculado_id").append(htmlCurso);

    // Abrindo o modal
    $("#modal-report-gra-aluno-matriculado_contatos").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportGraAlunoMatriculadoContatos').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId   = $('#report_id').val();
    var turnoId    = $('#turno_gra_aluno_matriculado_id').val();
    var cursoId    = $('#curso_gra_aluno_matriculado_id').val();

    // Validando as entradas
    if(!turnoId || !cursoId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_turnos,id=" + turnoId
        + "&fac_cursos,id="+cursoId, '_blank');
});