// carregando todos os campos preenchidos
function runSimpleReportGraVestOpcaoPorCurso()
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
            builderFilterOpcaoPorCurso(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Função a montar o html
function builderFilterOpcaoPorCurso (dados) {
    //Limpando os campos
    $('#cursos option').find('option').prop('selected', false);

    // Abrindo o modal
    $("#modal-opcao-por-curso").modal({show : true});
}

// Gerar o relatório
$('#btnGerarRelatorioOpcaoPorCurso').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var curso = $('#cursos').val();

    // Validando as entradas
    if(!curso) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_vestibulandos,primeira_opcao_curso_id="+curso, '_blank');
});