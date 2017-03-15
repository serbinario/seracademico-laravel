// carregando todos os cammes preenchidos
function runSimpleReportPosProfAtaAniversariante()
{
    builderFilterPosProfAtaDeAniversariante([]);
}

// Função a montar o html
function builderFilterPosProfAtaDeAniversariante(dados) {
    // Abrindo o modal
    $("#modal-report-pos-prof-ata-aniversariante").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportPosProfAtaAniversariante').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var mesAniversario = $('#mes_aniversario_pos_prof_ata_aniversariante').val();

    // Validando as entradas
    if(!mesAniversario) {
        swal('Todos os cammes do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?MONTH(pessoas,data_nasciemento)=" + mesAniversario, '_blank');
});