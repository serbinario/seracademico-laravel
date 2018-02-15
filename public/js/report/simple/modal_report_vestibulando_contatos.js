// carregando todos os campos preenchidos
function runSimpleReportGraVestContatos()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Turno',
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
            builderFilterVestibulandoContatos(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterVestibulandoContatos (dados) {
    //Limpando os campos
    $('#turno_vestibulando_contatos_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlTurno  = "<option value=''>Selecione um Turno</option>";

    // Percorrendo o array de Semestre
    for (var i = 0; i < dados['turno'].length; i++) {
        htmlTurno += "<option value='" + dados['turno'][i].id + "'>" + dados['turno'][i].nome + "</option>";
    }

    // carregando o html
    $("#turno_vestibulando_contatos_id option").remove();
    $("#turno_vestibulando_contatos_id").append(htmlTurno);

    // Abrindo o modal
    $("#modal-report-vestibulando-contatos").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportVestibulandooContatos').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId   = $('#report_id').val();
    var turnoId    = $('#turno_vestibulando_contatos_id').val();
    var cursoId    = $('#curno_vestibulando_contatos_id').val();

    // Validando as entradas
    if(!turnoId || !cursoId) {
        swal('Todos os campos do filtros são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_turnos,id=" + turnoId
        + "&fac_cursos,id="+cursoId, '_blank');
});