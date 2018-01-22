// carregando todos os campos preenchidos
function runSimpleReportGraVestFormaAdmissao()
{
    // Definindo os models
    var dados =  {
        'models' : []
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
            builderFilterFormaAdmissao(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Função a montar o html
function builderFilterFormaAdmissao (dados) {
    //Limpando os campos
    $('#forma_ingresso option').find('option').prop('selected', false);

    // Abrindo o modal
    $("#modal-forma-admissao").modal({show : true});
}

// Gerar o relatório
$('#btnGerarRelatorioFormaIngresso').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var formaAdmissao = $('#forma_ingresso').val();

    // Validando as entradas
    if(!formaAdmissao) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_vestibulandos,enem="+formaAdmissao, '_blank');
});