// carregando todos os cammes preenchidos
function runSimpleReportMesProfAtaAniversariante()
{
    builderFilterMesProfAtaDeAniversariante([]);
}

// Função a montar o html
function builderFilterMesProfAtaDeAniversariante(dados) {
    // Abrindo o modal
    $("#modal-report-mes-prof-ata-aniversariante").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportMesProfAtaAniversariante').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var mesAniversario = $('#mes_aniversario_mes_prof_ata_aniversariante').val();

    // Validando as entradas
    if(!mesAniversario) {
        swal('Todos os cammes do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?MONTH(pessoas,data_nasciemento)=" + mesAniversario, '_blank');
});