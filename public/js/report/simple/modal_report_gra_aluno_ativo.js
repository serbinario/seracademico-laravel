// carregando todos os campos preenchidos
function runSimpleReportGraAlunoAtivo()
{
    builderReportGraAlunoAtivo();
}

// Função a montar o html
function builderReportGraAlunoAtivo () {
    // Recuperando o id do relatório selecionado
    var reportId   = $('#report_id').val();

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/" + reportId, '_blank');
}