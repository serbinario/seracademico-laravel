// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#btnIncluirDisciplinas", function () {
    loadFieldsDisciplina();
});

// carregando todos os campos preenchidos
function loadFieldsDisciplina()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Disciplina|uniqueDisciplinaTurma,' + idTurma + ',' + periodo,
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/turma/disciplina/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {;
        // Verificando o retorno da requisição
        if(retorno['graduacao\\disciplina'].length > 0) {
            builderHtmlFieldsDisciplina(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            //$('#modal-disciplina-store').modal('hide');
            swal("Desculpe não existe disciplinas disponíveis", "Click no botão abaixo!", "error");

        }
    });
};

// Função a montar o html
function builderHtmlFieldsDisciplina (dados) {
    // limpando os campos
    $("#disciplina_id").find("option").eq(0).prop("selected", true);

    // Variáveis que armazenaram o html
    var htmlDisciplina     = "<option value=''>Selecione uma disciplina</option>";

    // Percorrendo o array de disciplinacurriculo
    for(var i = 0; i < dados['graduacao\\disciplina'].length; i++) {
        // Criando as options
        htmlDisciplina += "<option value='" + dados['graduacao\\disciplina'][i].id + "'>" + dados['graduacao\\disciplina'][i].codigo + " : " + dados['graduacao\\disciplina'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de período
    $("#disciplina_id option").remove();
    $("#disciplina_id").append(htmlDisciplina);

    // Abrindo o modal de inserir disciplina
    $("#modal-disciplina-store").modal({show : true});
};

// Evento para salvar tabela de preços
$('#btnSalvarDisciplinaTurma').click(function() {
    var disciplina_id = $("#disciplina_id").val();

    var dados = {
        'idTurma' : idTurma,
        'disciplina_id': disciplina_id
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/turma/disciplina/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            table.ajax.reload();
            tableDisciplina.ajax.reload();
            $('#modal-disciplina-store').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});