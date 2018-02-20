// carregando todos os campos preenchidos
function runSimpleReportGraTurmaAtaDeAssinaturaTurno()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Curso|ativo,1',
            'Turno'
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
            builderFilterGraTurmaAtaDeAssinaturaTurno(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterGraTurmaAtaDeAssinaturaTurno (dados) {
    //Limpando os campos
    $('#curso_gra_turma_ata_assinatura_turno_id option').find('option').prop('selected', false);
    $('#turno_gra_turma_ata_assinatura_turno_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlCurso  = "<option value=''>Selecione um Curso</option>";
    var htmlTurno  = "<option value=''>Selecione um Turno</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['graduacao\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['graduacao\\curso'][i].id + "'>" + dados['graduacao\\curso'][i].nome + "</option>";
    }

    // Percorrendo o array de turno
    for (var i = 0; i < dados['turno'].length; i++) {
        htmlTurno += "<option value='" + dados['turno'][i].id + "'>" + dados['turno'][i].nome + "</option>";
    }

    // carregando o html
    $("#curso_gra_turma_ata_assinatura_turno_id option").remove();
    $("#curso_gra_turma_ata_assinatura_turno_id").append(htmlCurso);
    $("#turno_gra_turma_ata_assinatura_turno_id option").remove();
    $("#turno_gra_turma_ata_assinatura_turno_id").append(htmlTurno);

    // Abrindo o modal
    $("#modal-report-gra-turma-ata-assinatura-turno").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportGraTurmaAtaAssinaturaTurno').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_gra_turma_ata_assinatura_turno_id').val();
    var turnoId  = $('#turno_gra_turma_ata_assinatura_turno_id').val();

    // Validando as entradas
    if(!cursoId || !turnoId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turnos,id="+turnoId, '_blank');
});