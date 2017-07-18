// carregando todos os cammes preenchidos
function runSimpleReportMesProfessorVinculo()
{
    builderFilterMesProfessorVinculo([]);
}

// Função a montar o html
function builderFilterMesProfessorVinculo(dados) {
    // Abrindo o modal
    $("#modal-report-mes-prof-vinculo").modal({show : true});
}

// Gerar o relatório
$('#btnBuilderReportMesProfessorVinculo').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var idProfessor = $('#mes_professor_id').val();
    var idDisciplina = $('#mes_disciplina_id').val();

    // Validando as entradas
    if(!idProfessor && !idDisciplina) {
        swal('Todos os campos do filtro são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId +"?fac_professores,id="+idProfessor+"&fac_disciplinas,id"+idDisciplina, '_blank');
});

jQuery.ajax({
    type: 'POST',
    url: '/index.php/seracademico/mestrado/professor/getProfessor',
    datatype: 'json'
}).done(function (json) {
    var option = "";
    option += '<option value="">Selecione um professor</option>';

    for (var i = 0; i < json.dados.length; i++) {
        option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['nome'] + '</option>';
    }

    $('#mes_professor_id option').remove();
    $('#mes_professor_id').append(option);
});

jQuery.ajax({
    type: 'POST',
    url: '/index.php/seracademico/mestrado/professor/getDisciplina',
    datatype: 'json'
}).done(function (json) {
    var option = "";
    option += '<option value="">Selecione uma disciplina</option>';

    for (var i = 0; i < json.dados.length; i++) {
        option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['nome'] + '</option>';
    }

    $('#mes_disciplina_id option').remove();
    $('#mes_disciplina_id').append(option);
});