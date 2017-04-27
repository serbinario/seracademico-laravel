// carregando todos os campos preenchidos
function runSimpleReportPosCadernetaFrequencia()
{
    console.log('aa');
    // Abindo o modal
    $("#modal-report-pos-aluno-caderneta").modal({show : true});
}
// Gerar o relatório
$('#btnBuilderReportPosAlunoCaderneta').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/" + reportId, '_blank');
});
