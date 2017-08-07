var idProfessor;

// carregando todos os campos preenchidos
function runSimpleReportDouProfessorVinculo()
{
    builderFilterDouProfessorVinculo([]);
}

// Função a montar o html
function builderFilterDouProfessorVinculo(dados) {
    // Abrindo o modal
    $("#modal-report-dou-prof-vinculo").modal({show : true});
}

jQuery.ajax({
    type: 'POST',
    url: '/index.php/seracademico/doutorado/professor/getProfessor',
    datatype: 'json'
}).done(function (json) {
    var option = "";
    option += '<option value="">Selecione um professor</option>';

    for (var i = 0; i < json.dados.length; i++) {
        option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['nome'] + '</option>';
    }

    $('#dou_professor_id option').remove();
    $('#dou_professor_id').append(option);
});

$("#dou_professor_id").change(function() {
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/doutorado/professor/getDisciplina/' + $('#dou_professor_id').val(),
        datatype: 'json'
    }).done(function (json) {
        var option = "";
        option += '<option value="">Selecione uma disciplina</option>';

        for (var i = 0; i < json.dados.length; i++) {
            option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['nome'] + '</option>';
        }

        $('#dou_disciplina_id option').remove();
        $('#dou_disciplina_id').append(option);
    });
});

// Gerar o relatório
$('#btnBuilderReportDouProfessorVinculo').click(function() {
    // Recuperando o id do relatório selecionado
    var reportId = $('#report_id').val();
    var idProfessor = $('#dou_professor_id').val();
    var idDisciplina = $('#dou_disciplina_id').val();
    console.log(idDisciplina);
    // Validando as entradas
    if(!idProfessor && !idDisciplina) {
        swal('Todos os campos do filtro são obrigatórios!', 'Click no botão abaixo', 'error');
        return false;
    }

    // Executando o relatório e abrindo em outra aba
    window.open("/index.php/seracademico/report/"
        + reportId +"?fac_professores,id="+idProfessor+"&fac_disciplinas,id="+idDisciplina, '_blank');
});