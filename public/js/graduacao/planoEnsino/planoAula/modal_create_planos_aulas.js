// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnCreatePlanoAula", function () {
    loadFieldsPlanoAula();
});

// carregando todos os campos preenchidos
function loadFieldsPlanoAula()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Professor|getValues',
            'Graduacao\\ConteudoProgramatico|byPlanoEnsino,' + idPlanoEnsino
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/planoEnsino/planoAula/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsPlanoAula(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-planos-aulas').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsPlanoAula (dados) {
    //Limpando os campos
    $('#professor_1_id option').attr('selected', false);
    $('#professor_2_id option').attr('selected', false);
    $('#professor_3_id option').attr('selected', false);
    $('#professor_4_id option').attr('selected', false);
    $('#professor_5_id option').attr('selected', false);
    $('#hora_inicial').val('');
    $('#numero_aula').val('');
    $('#hora_final').val('');
    $('#data').val('');

    // Variáveis que armazenaram o html
    var htmlProfessor = "<option value=''>Selecione um Professor</option>";
    var htmlConteudo  = "<option value=''>Selecione um Conteudo</option>";

    // Percorrendo o array de cursos
    for (var i = 0; i < dados['professor'].length; i++) {
        htmlProfessor += "<option value='" + dados['professor'][i].id + "'>" + dados['professor'][i].nome + "</option>";
    }

    // Percorrendo o array de cursos
    for (var i = 0; i < dados['graduacao\\conteudoprogramatico'].length; i++) {
        htmlConteudo += "<option value='" + dados['graduacao\\conteudoprogramatico'][i].id + "'>" + dados['graduacao\\conteudoprogramatico'][i].nome + "</option>";
    }

    // Carregando os selects de professores
    $("#professor_1_id option").remove();
    $("#professor_1_id").append(htmlProfessor);
    $("#professor_2_id option").remove();
    $("#professor_2_id").append(htmlProfessor);
    $("#professor_3_id option").remove();
    $("#professor_3_id").append(htmlProfessor);
    $("#professor_4_id option").remove();
    $("#professor_4_id").append(htmlProfessor);
    $("#professor_5_id option").remove();
    $("#professor_5_id").append(htmlProfessor);
    $("#conteudo_plano_aula option").remove();
    $("#conteudo_plano_aula").append(htmlConteudo);

    // Carregando a grid de conteúdo programático
    loadCreateTableConteudoProgramaticoPlanoAula();

    // Abrindo o modal de inserir disciplina
    $("#modal-create-planos-aulas").modal({show : true});
}

// Evento para salvar histórico
$('#btnSavePlanoAula').click(function() {
    var professor_1_id  = $("#professor_1_id").val();
    var professor_2_id  = $("#professor_2_id").val();
    var professor_3_id  = $("#professor_3_id").val();
    var professor_4_id  = $("#professor_4_id").val();
    var professor_5_id  = $("#professor_5_id").val();
    var hora_inicial    = $("#hora_inicial").val();
    var numero_aula     = $("#numero_aula").val();
    var hora_final      = $("#hora_final").val();
    var data            = $("#data").val();

    // Array de conteúdos
    var conteudos  = [];

    // Carregando as taxas
    $.each(tableConteudoPlanoAula.rows().data(),function (index, val) {
        conteudos[index] = val[0];
    });

    var dados = {
        'plano_ensino_id': idPlanoEnsino,
        'professor_1_id' : professor_1_id,
        'professor_2_id' : professor_2_id,
        'professor_3_id' : professor_3_id,
        'professor_4_id' : professor_4_id,
        'professor_5_id' : professor_5_id,
        'hora_inicial'   : hora_inicial,
        'numero_aula'    : numero_aula,
        'hora_final'     : hora_final,
        'conteudos'      : conteudos,
        'data'           : data
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/planoEnsino/planoAula/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tablePlanoAula.ajax.reload();

            $('#modal-create-planos-aulas').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

