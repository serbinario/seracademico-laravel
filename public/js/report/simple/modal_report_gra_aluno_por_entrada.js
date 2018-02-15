// carregando todos os campos preenchidos
function runSimpleReportGraAlunoPorTipoEntrada()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'FormaAdmissao'
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
            builderFilterGraAlunoPorEntrada(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterGraAlunoPorEntrada (dados) {
    //Limpando os campos
    $('#tipo_gra_aluno_por_entrada_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlFormaAdmissao  = "<option value=''>Selecione um tipo</option>";

    // Percorrendo o array de Semestre
    for (var i = 0; i < dados['formaadmissao'].length; i++) {
        htmlFormaAdmissao += "<option value='" + dados['formaadmissao'][i].id + "'>" + dados['formaadmissao'][i].nome + "</option>";
    }

    // carregando o html
    $("#tipo_gra_aluno_por_entrada_id option").remove();
    $("#tipo_gra_aluno_por_entrada_id").append(htmlFormaAdmissao);

    // Abrindo o modal
    $("#modal-report-gra-aluno-por-entrada").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportGraAlunoPorEntrada').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId   = $('#report_id').val();
    var formaAdmissaoId    = $('#tipo_gra_aluno_por_entrada_id').val();

    // Validando as entradas
    if(!formaAdmissaoId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?formas_admissoes,id=" + formaAdmissaoId, '_blank');
});