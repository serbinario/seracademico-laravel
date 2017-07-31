// carregando todos os campos preenchidos
function runSimpleReportDouCurriculoDisciplina()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Doutorado\\Curriculo|Doutorado',
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
            builderFilterDouCurriculoDisciplina(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterDouCurriculoDisciplina (dados) {
    //Limpando os campos
    $('#curriculo_dou_curriculo_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlCurriculo  = "<option value=''>Selecione um Currículo</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['doutorado\\curriculo'].length; i++) {
        htmlCurriculo += "<option value='" + dados['doutorado\\curriculo'][i].id + "'>" + dados['doutorado\\curriculo'][i].nome + "</option>";
    }

    // carregando o html
    $("#curriculo_dou_curriculo_id option").remove();
    $("#curriculo_dou_curriculo_id").append(htmlCurriculo);

    // Abrindo o modal
    $("#modal-report-dou-curriculo-disciplina").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportDouCurriculoDisciplina').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var curriculoId = $('#curriculo_dou_curriculo_id').val();

    // Validando as entradas
    if(!curriculoId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_curriculos,id="+curriculoId, '_blank');
});