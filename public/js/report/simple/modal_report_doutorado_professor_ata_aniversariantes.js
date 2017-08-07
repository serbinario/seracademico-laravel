// carregando todos os campos preenchidos
function runSimpleReportDouProfAtaAniversariante()
{
    builderFilterDouProfAtaDeAniversariante([]);
}

// Função a montar o html
function builderFilterDouProfAtaDeAniversariante(dados) {
    // Abrindo o modal
    $("#modal-report-dou-prof-ata-aniversariante").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportDouProfAtaAniversariante').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var mesAniversario = $('#mes_aniversario_dou_prof_ata_aniversariante').val();

    // Validando as entradas
    if(!mesAniversario) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?MONTH(pessoas,data_nasciemento)=" + mesAniversario, '_blank');
});