// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#btnAdicionarOpcaoEletiva", function () {
    loadFieldsOpcaoEletiva();
});

// carregando todos os campos preenchidos
function loadFieldsOpcaoEletiva()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Semestre',
            'Graduacao\\Disciplina|lessCurriculo,' + idCurriculo
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/curriculo/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {// validado as disciplinas do currículo
        // Verificando o retorno da requisição
        if(retorno['graduacao\\disciplina'].length > 0) {
            builderHtmlFields(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal("Desculpe não existe disciplinas disponíveis", "Click no botão abaixo!", "error");
            $('#modal-store-adicinar-eletiva').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFields (dados) {
    // limpando os campos
    $("#semestre_eletiva_id").find("option").prop("selected", true);
    $("#disciplina_opcao_eletiva_id").find("option").prop("selected", true);

    // Variáveis que armazenaram o html
    var htmlSemestre    = "<option value=''>Selecione um semestre</option>";
    var htmlDisciplina  = "<option value=''>Selecione uma eletiva</option>";

    // Percorrendo o array de disciplina
    for (var i = 0; i < dados['graduacao\\disciplina'].length; i++) {
        htmlDisciplina += "<option value='" + dados['graduacao\\disciplina'][i].id + "'>" + dados['graduacao\\disciplina'][i].nome + "</option>";
    }

    // Percorrendo o array de semestres
    for (var i = 0; i < dados['graduacao\\semestre'].length; i++) {
        htmlSemestre += "<option value='" + dados['graduacao\\semestre'][i].id + "'>" + dados['graduacao\\semestre'][i].nome + "</option>";
    }

    // carregando o html
    $("#disciplina_opcao_eletiva_id option").remove();
    $("#disciplina_opcao_eletiva_id").append(htmlDisciplina);
    $("#semestre_eletiva_id option").remove();
    $("#semestre_eletiva_id").append(htmlSemestre);

    // Abrindo o modal de inserir disciplina
    $("#modal-store-adicionar-eletiva").modal({show : true});
}

// Evento para salvar tabela de preços
$('#btnStoreAdicionarEletiva').click(function() {
    // Recupernando os valores do formulário
    var semestre_eletiva_id   = $("#semestre_eletiva_id").val();
    var disciplina_eletiva_id = $("#disciplina_opcao_eletiva_id").val();

    // Dados da requisição
    var dados = {
        'disciplina_eletiva_id' : disciplina_eletiva_id,
        'semestre_eletiva_id': semestre_eletiva_id,
        'curriculo_disciplina_id': idCurriculoDisciplinaEletiva
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curriculo/eletiva/storeOpcaoEletiva',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableOpcoesEletivas.ajax.reload();
            $('#modal-store-adicionar-eletiva').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnRemoveOpcaoEletiva', function () {
    // Recuperando o id da opção eletiva
    var idOpcaoEletiva = tableOpcoesEletivas.row($(this).parents("tr")).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/curriculo/eletiva/deleteOpcaoEletiva/' + idOpcaoEletiva,
        datatype: 'json'
    }).done(function (retorno) {
        tableOpcoesEletivas.ajax.reload();
        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});
