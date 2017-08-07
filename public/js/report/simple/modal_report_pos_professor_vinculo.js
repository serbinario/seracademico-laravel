var idProfessor;

// carregando todos os campos preenchidos
function runSimpleReportPosProfessorVinculo()
{
    builderFilterPosProfessorVinculo([]);
}

// Função a montar o html
function builderFilterPosProfessorVinculo(dados) {
    // Abrindo o modal
    $("#modal-report-pos-prof-vinculo").modal({show : true});
}

jQuery.ajax({
    type: 'POST',
    url: '/index.php/seracademico/posgraduacao/professor/getProfessor',
    datatype: 'json'
}).done(function (json) {

    var option = "";
    option += '<option value="">Selecione um professor</option>';

    for (var i = 0; i < json.dados.length; i++) {
        option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['nome'] + '</option>';
    }

    $('#pos_professor_id option').remove();
    $('#pos_professor_id').append(option);
});

$("#pos_professor_id").change(function() {
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/professor/getDisciplina/' + $('#pos_professor_id').val(),
        datatype: 'json'
    }).done(function (json) {
        var option = "";
        option += '<option value="">Selecione uma disciplina</option>';

        for (var i = 0; i < json.dados.length; i++) {
            option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['nome'] + '</option>';
        }

        $('#pos_disciplina_id option').remove();
        $('#pos_disciplina_id').append(option);
    });
});

// Gerar o relatório
$('#btnBuilderReportPosProfessorVinculo').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var idProfessor = $('#pos_professor_id').val();
    var idDisciplina = $('#pos_disciplina_id').val();

    // Validando as entradas
    if(!idProfessor && !idDisciplina) {
        swal('Todos os campos do filtro são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId +"?fac_professores,id="+idProfessor+"&fac_disciplinas,id="+idDisciplina, '_blank');
});