// evento para abrir modal de adicionar curso ao aluno
$(document).on("click", "#adicionar-curso", function () {
    // Carregando os campos
    loadFields();
    loadCursosAluno();
    
    // Escondendo o img de load
    $('#load').hide();
    
    // Exibindo o modal
    $("#modal-nova-turma-aluno").modal({show:true});
});

// carregando todos os campos preenchidos
function loadFields()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'SituacaoAluno',
            'Instituicao'
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
            builderHtmlFields(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-nova-turma-aluno').modal('toggle');
        }
    });
}

// Função a montar o html
function builderHtmlFields (dados) {
    // Variáveis que armazenaram o html
    var htmlSituacao    = "<option value=''>Selecione uma situação</option>";

    // Percorrendo o array de situacaoaluno
    for(var i = 0; i < dados['situacaoaluno'].length; i++) {
        // Criando as options
        htmlSituacao += "<option value='" + dados['situacaoaluno'][i].id + "'>"  + dados['situacaoaluno'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de situacao aluno
    $("#situacao_id option").remove();
    $("#situacao_id").append(htmlSituacao);
}

// carregando os cursos para nova turma do aluno
function loadCursosAluno()
{
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/aluno/turma/getCursos',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            // Variável que armazenará o html
            var html = "<option value=''>Selecione um curso</option>";

            // Percorrendo o array
            for(var i = 0; i < retorno.length; i++) {
                // Criando as options
                html += "<option value='" + retorno[i].curriculo_id + "'>"  + retorno[i].nome_curso + "</option>";
            }

            // Removendo e adicionando as options
            $("#curso option").remove();
            $("#curso").append(html);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-nova-turma-aluno').modal('toggle');
        }
    });
}

// Função para carregar as turmas vincularas a curriculo
function loadTurmasAluno(idCurriculo)
{
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/aluno/turma/getTurmas/' + idCurriculo,
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            // Variável que armazenará o html
            var html = "<option value=''>Selecione uma turma</option>";

            // Percorrendo o array
            for(var i = 0; i < retorno.length; i++) {
                // Criando as options
                html += "<option value='" + retorno[i].id + "'>"  + retorno[i].codigo + "</option>";
            }

            // Removendo e adicionando as options
            $("#turma_id option").remove();
            $("#turma_id").append(html);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-nova-turma-aluno').modal('toggle');
        }
    });
}

// evento quando selecionar o curso
$(document).on("change", "#curso", function () {
   // recuperando as options
   var options = $(this).find("option");

    // Verificando se existe options
    if(options.length > 0) {
        // Recuperando o valor selecionado
        var idCurriculo = $(this).find("option:selected").val();

        // verificando se existe curso selecionado
        if (idCurriculo == "") {
            // Removendo as options
            $("#turma_id option").remove();
        } else {
            // carregando as turmas
            loadTurmasAluno(idCurriculo);
        }
    }
});

// Limpa os valores dos campos
function clearValueFields()
{
    // Iniciais
    $("#curso").find("option:selected").removeAttr("selected");
    $("#turma_id option").remove();
    $("#situacao_id").find("option:selected").removeAttr("selected");
}

// Recuperando os valores dos campos
function getValueFields()
{
    // Iniciais
    var curriculo_id            = $("#curso").val();
    var turma_id                = $("#turma_id").val();
    var situacao_id             = $("#situacao_id").val();


    // Preparando os dados
    var dados = {
        'curriculo_id'            : curriculo_id,
        'aluno_id'                : idAluno,
        'turma_id'                : turma_id == "" ? null : turma_id,
        'situacao_id'             : situacao_id == "" ? null : situacao_id
    };

    // Retorno
    return dados;
}

// Evento de click do botão de salvar turma do aluno
$(document).on("click", "#btnSalvarTurmaAluno", function () {
    // Recuperando os valores dos formulários
    var dados = getValueFields();
  
    // Transação com banco de dados
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/aluno/turma/store',
        data: dados,
        datatype: 'json',
        beforeSend: function() {
            $('#load').show();
        },
        complete: function(){
            $('#load').hide();
        },
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableCursoTurma.ajax.reload();
            loadTableSituacoes(0).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridSituacoes/" + 0).load();

            // desabilitando o butão
            $('#btnAdicionarSituacao').attr('disabled', true);
            
            // Limpando os campos
            clearValueFields();

            // Fechando o modal
            $("#modal-nova-turma-aluno").modal('toggle');

            // Mensagem de retorno
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });

});