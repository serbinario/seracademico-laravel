// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnAddHistorico", function () {
    loadFieldsHistorico();
});

// carregando todos os campos preenchidos
function loadFieldsHistorico()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Curso|byCurriculoAtivo,1',
            'Turno',
            'FormaAdmissao',
            'Graduacao\\Semestre'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/aluno/historico/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsHistorico(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-historico').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsHistorico (dados) {
    //Limpando os campos
    $('#curso_id option').attr('selected', false);
    $('#forma_admissao_id option').attr('selected', false);
    $('#turno_id option').attr('selected', false);
    $('#data_inclusao').val('');


    // Variáveis que armazenaram o html
    var htmlCurso     = "";
    var htmlTurno     = "";
    var htmlFAdmissao = "";
    var htmlSemestre  = "";

    // Percorrendo o array de cursos
    for (var i = 0; i < dados['graduacao\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['graduacao\\curso'][i].id + "'>" + dados['graduacao\\curso'][i].nome + "</option>";

    }

    // Percorrendo o array de turnos
    for (var i = 0; i < dados['turno'].length; i++) {
        htmlTurno += "<option value='" + dados['turno'][i].id + "'>" + dados['turno'][i].nome + "</option>";

    }

    // Percorrendo o array de formas de admissoes
    for (var i = 0; i < dados['formaadmissao'].length; i++) {
        htmlFAdmissao += "<option value='" + dados['formaadmissao'][i].id + "'>" + dados['formaadmissao'][i].nome + "</option>";

    }

    // Percorrendo o array de semestres
    for (var i = 0; i < dados['graduacao\\semestre'].length; i++) {
        htmlSemestre += "<option value='" + dados['graduacao\\semestre'][i].id + "'>" + dados['graduacao\\semestre'][i].nome + "</option>";
    }

    $("#curso_id option").remove();
    $("#curso_id").append(htmlCurso);

    $("#turno_id option").remove();
    $("#turno_id").append(htmlTurno);

    $("#forma_admissao_id option").remove();
    $("#forma_admissao_id").append(htmlFAdmissao);

    $("#semestre_id option").remove();
    $("#semestre_id").append(htmlSemestre);

    // Abrindo o modal de inserir disciplina
    $("#modal-create-historico").modal({show : true});
}

// Evento para salvar histórico
$('#btnSaveHistorico').click(function() {
    var curso_id  = $("#curso_id").val();
    var turno_id  = $("#turno_id").val();
    var forma_admissao_id = $("#forma_admissao_id").val();
    var data_inclusao = $("#data_inclusao").val();
    var semestre_id   = $("#semestre_id").val();
    var periodo       = $("#periodo").val();

    var dados = {
        'periodo' : periodo,
        'semestre_id' : semestre_id,
        'curso_id': curso_id,
        'turno_id': turno_id,
        'forma_admissao_id' : forma_admissao_id,
        'data_inclusao' : data_inclusao,
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/historico/save/' + idAluno,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            table.ajax.reload();
            tableHistorico.ajax.reload();
            // tableHistorico.ajax.reload(function () {
            //     tablePrecosCurso.row(indexRowSelectedPrecoCurso).nodes().to$().find('td').addClass("row_selected");
            // });
            $('#modal-create-historico').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDeleteHistorico', function () {
    // recuperando o id do aluno_semestre
    var idAlunoSemestre = tableHistorico.row($(this).parent().parent().index()).data().idAlunoSemestre;

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/historico/delete/' + idAlunoSemestre,
        datatype: 'json'
    }).done(function (retorno) {
        table.ajax.reload();
        tableHistorico.ajax.reload();
        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});