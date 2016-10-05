// carregando todos os campos preenchidos
function runSimpleReportGraTurmaAtaDeAssinatura()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Curso|ativo,1',
            'Graduacao\\Turma|graduacao',
            'Graduacao\\Disciplina|tipoNivelSistema,1'
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
            builderFilterGraTurmaAtaDeAssinatura(retorno);
        } else {
            // Retorno tenha dado erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderFilterGraTurmaAtaDeAssinatura (dados) {
    //Limpando os campos
    $('#curso_gra_turma_ata_assinatura_id option').find('option').prop('selected', false);
    $('#turma_gra_turma_ata_assinatura_id option').find('option').prop('selected', false);
    $('#disciplina_gra_turma_ata_assinatura_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlCurso  = "<option value=''>Selecione um Curso</option>";
    var htmlTurma  = "<option value=''>Selecione uma Turma</option>";
    var htmlDisciplina = "<option value=''>Selecione uma Disciplina</option>";

    // Percorrendo o array de Curso
    for (var i = 0; i < dados['graduacao\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['graduacao\\curso'][i].id + "'>" + dados['graduacao\\curso'][i].nome + "</option>";
    }

    // Percorrendo o array de turma
    for (var i = 0; i < dados['graduacao\\turma'].length; i++) {
        htmlTurma += "<option value='" + dados['graduacao\\turma'][i].id + "'>" + dados['graduacao\\turma'][i].nome + "</option>";
    }

    // Percorrendo o array de turno
    for (var i = 0; i < dados['graduacao\\disciplina'].length; i++) {
        htmlDisciplina += "<option value='" + dados['graduacao\\disciplina'][i].id + "'>" + dados['graduacao\\disciplina'][i].nome + "</option>";
    }

    // carregando o html
    $("#curso_gra_turma_ata_assinatura_id option").remove();
    $("#curso_gra_turma_ata_assinatura_id").append(htmlCurso);
    $("#turma_gra_turma_ata_assinatura_id option").remove();
    $("#turma_gra_turma_ata_assinatura_id").append(htmlTurma);
    $("#disciplina_gra_turma_ata_assinatura_id option").remove();
    $("#disciplina_gra_turma_ata_assinatura_id").append(htmlDisciplina);

    // Abrindo o modal
    $("#modal-report-gra-turma-ata-assinatura").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportGraTurmaAtaAssinatura').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var cursoId  = $('#curso_gra_turma_ata_assinatura_id').val();
    var turmaId  = $('#turma_gra_turma_ata_assinatura_id').val();
    var disciplinaId  = $('#disciplina_gra_turma_ata_assinatura_id').val();

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId+"&fac_disciplinas,id="+disciplinaId, '_blank');
});