// evento para abrir modal de adicionar curso ao aluno
$(document).on("click", "#btnAdicionarSituacao", function () {
    // Verificando se o id do alunocurso foi informado
    if($(document).find('#btnAdicionarSituacao').attr('disabled')) {
        return false;
    }

    // Carregando os campos
    loadFieldsSituacao();
});

// carregando todos os campos preenchidos
function loadFieldsSituacao()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'SituacaoAluno',
            'PosGraduacao\\Turma|posGraduacaoByAlunoCurso,' + idAlunoCurso
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/posgraduacao/aluno/turma/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsSituacao(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-situacao').modal('toggle');
        }
    });
}

// Função a montar o html
function builderHtmlFieldsSituacao (dados) {
    // Limpando os campos
    clearValueFieldsSituacao();

    // Escondendo os campos
    $('#rowTurmaOrigem').hide();
    $('#rowTurmaDestino').hide();

    // Variáveis que armazenaram o html
    var htmlSituacao = "<option value=''>Selecione uma situação</option>";
    var htmlTurma    = "<option value=''>Selecione uma turma</option>";
    
    // Percorrendo o array de situacaoaluno
    for(var i = 0; i < dados['situacaoaluno'].length; i++) {
        // Criando as options
        htmlSituacao += "<option value='" + dados['situacaoaluno'][i].id + "'>"  + dados['situacaoaluno'][i].nome + "</option>";
    }

    // Percorrendo o array de professor
    for(var i = 0; i < dados['posgraduacao\\turma'].length; i++) {

        // Criando as options
        htmlTurma += "<option value='" + dados['posgraduacao\\turma'][i].id + "'>"  + dados['posgraduacao\\turma'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de situacao
    $("#situacao_create_id option").remove();
    $("#situacao_create_id").append(htmlSituacao);

    // Removendo e adicionando as options de turmas
    $("#turma_destino_id option").remove();
    $("#turma_destino_id").append(htmlTurma);

    // Carregando a turma de origem
    loadTurmaOrigem();

    // Exibindo o modal
    $('#modal-create-situacao').modal({show:true});
}

// Função para carregar a turma de origem
function loadTurmaOrigem()
{
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/aluno/turma/getTurmaOrigem/' + idAlunoCurso,
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            // Variável que armazenará o html
            var html = "";

            // Percorrendo o array
            for(var i = 0; i < retorno.length; i++) {
                // Criando as options
                html += "<option value='" + retorno[i].id + "'>"  + retorno[i].nome + "</option>";
            }

            // Removendo e adicionando as options
            $("#turma_origem_id option").remove();
            $("#turma_origem_id").append(html);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-situacao').modal('toggle');
        }
    });
}

// Evento para tratamento da exibição dos campos de turmas
$(document).on('click', '#situacao_create_id', function() {
    // Recuperando o id da situacao
    var idSituacao = $(this).val();

    // Vendo se a situação escolhida foi mudança de turma
    if (idSituacao == 14) {
        $('#rowTurmaOrigem').show();
        $('#rowTurmaDestino').show();
    } else {
        $('#rowTurmaOrigem').hide();
        $('#rowTurmaDestino').hide();
    }
});

// Limpa os valores dos campos
function clearValueFieldsSituacao()
{
    // Iniciais
    $("#situacao_create_id").find("option:selected").removeAttr("selected");
    $("#turma_origem_id option").remove();
    $("#turma_destino_id").find("option:selected").removeAttr("selected");
}

// Recuperando os valores dos campos
function getValueFieldsSituacao()
{
    // Iniciais
    var situacao_id      = $("#situacao_create_id").val();
    var turma_origem_id  = $("#turma_origem_id").val();
    var turma_destino_id = $("#turma_destino_id").val();


    // Preparando os dados
    var dados = {
        'situacao_id'        : situacao_id,
        'pos_aluno_curso_id' : idAlunoCurso,
        'turma_origem_id'    : turma_origem_id,
        'turma_destino_id'   : turma_destino_id
    };

    // Retorno
    return dados;
}

// Evento de click do botão de salvar turma do aluno
$(document).on("click", "#btnSalvarSituacao", function () {
    // Recuperando os valores dos formulários
    var dados = getValueFieldsSituacao();

    // Transação com banco de dados
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/aluno/turma/storeSituacao',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableSituacoes.ajax.reload();
            tableCursoTurma.ajax.reload(function () {
                tableCursoTurma.row(indexRowSelectedCurso).nodes().to$().find('td').addClass("row_selected");
            });

            // Limpando os campos
            clearValueFieldsSituacao();

            // Fechando o modal
            $("#modal-create-situacao").modal('toggle');

            // Mensagem de retorno
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });

});

// Evento para remover a situação
$(document).on('click', '#btnRemoverSituacao', function () {
    // Recuperando o id da situação do aluno
    var idAlunoSituacao = tableSituacoes.row($(this).parents('tr')).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'DELETE',
        url: '/index.php/seracademico/posgraduacao/aluno/turma/destroySituacao/' + idAlunoSituacao,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableSituacoes.ajax.reload();
            tableCursoTurma.ajax.reload(function () {
                tableCursoTurma.row(indexRowSelectedCurso).nodes().to$().find('td').addClass("row_selected");
            });

            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});