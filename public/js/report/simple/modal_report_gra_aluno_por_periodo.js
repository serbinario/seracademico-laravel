// carregando todos os campos preenchidos
function runSimpleReportGraAlunoPorPeriodo()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Semestre',
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
            builderFilterGraAlunoPorVestibular(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterGraAlunoPorVestibular (dados) {
    //Limpando os campos
    $('#semestre_gra_aluno_por_periodo_id option').find('option').prop('selected', false);
    $('#periodo_gra_aluno_por_periodo_id option').find('option').prop('selected', false);
    $('#curso_gra_aluno_por_periodo_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlSemestre  = "<option value=''>Selecione um Semester</option>";
    var htmlCurso     = "<option value=''>Selecione um Curso</option>";

    // Percorrendo o array de Semestre
    for (var i = 0; i < dados['graduacao\\semestre'].length; i++) {
        htmlSemestre += "<option value='" + dados['graduacao\\semestre'][i].id + "'>" + dados['graduacao\\semestre'][i].nome + "</option>";
    }

    // Percorrendo o array do Curso
    for (var i = 0; i < dados['graduacao\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['graduacao\\curso'][i].id + "'>" + dados['graduacao\\curso'][i].nome + "</option>";
    }

    // carregando o html
    $("#semestre_gra_aluno_por_periodo_id option").remove();
    $("#semestre_gra_aluno_por_periodo_id").append(htmlSemestre);
    $("#curso_gra_aluno_por_periodo_id option").remove();
    $("#curso_gra_aluno_por_periodo_id").append(htmlCurso);

    // Abrindo o modal
    $("#modal-report-gra-aluno-por-periodo").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportGraAlunoPorPeriodo').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId   = $('#report_id').val();
    var semestreId = $('#semestre_gra_aluno_por_periodo_id').val();
    var periodo    = $('#periodo_gra_aluno_por_periodo_id').val();
    var cursoId    = $('#curso_gra_aluno_por_periodo_id').val();

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_semestres,id=" + semestreId + "&fac_alunos_semestres,periodo="+periodo
        + "&fac_cursos,id="+cursoId, '_blank');
});