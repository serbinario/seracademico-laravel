// carregando todos os campos preenchidos
function runSimpleReportGraAlunoPorVestibular()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Semestre'
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
    $('#semestre_gra_aluno_por_vestibular_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlSemestre  = "<option value=''>Selecione um Semester</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['graduacao\\semestre'].length; i++) {
        htmlSemestre += "<option value='" + dados['graduacao\\semestre'][i].id + "'>" + dados['graduacao\\semestre'][i].nome + "</option>";
    }

    // carregando o html
    $("#semestre_gra_aluno_por_vestibular_id option").remove();
    $("#semestre_gra_aluno_por_vestibular_id").append(htmlSemestre);

    // Abrindo o modal
    $("#modal-report-gra-aluno-por-vestibular").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportGraAlunoPorVestibular').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId   = $('#report_id').val();
    var semestreId = $('#semestre_gra_aluno_por_vestibular_id').val();

    // Validando as entradas
    if(!semestreId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_semestres,id=" + semestreId, '_blank');
});