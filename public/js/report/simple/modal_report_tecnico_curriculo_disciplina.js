// carregando todos os campos preenchidos
function runSimpleReportTecCurriculoDisciplina()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Tecnico\\Curriculo|Tecnico',
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
            builderFilterTecCurriculoDisciplina(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterTecCurriculoDisciplina (dados) {
    //Limpando os campos
    $('#curriculo_tec_curriculo_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlCurriculo  = "<option value=''>Selecione um Currículo</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['tecnico\\curriculo'].length; i++) {
        htmlCurriculo += "<option value='" + dados['tecnico\\curriculo'][i].id + "'>" + dados['tecnico\\curriculo'][i].nome + "</option>";
    }

    // carregando o html
    $("#curriculo_tec_curriculo_id option").remove();
    $("#curriculo_tec_curriculo_id").append(htmlCurriculo);

    // Abrindo o modal
    $("#modal-report-tec-curriculo-disciplina").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportTecCurriculoDisciplina').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var curriculoId = $('#curriculo_tec_curriculo_id').val();

    // Validando as entradas
    if(!curriculoId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_curriculos,id="+curriculoId, '_blank');
});