// carregando todos os campos preenchidos
function loadFields()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'SituacaoAluno',
            'Professor',
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
    var htmlProfessor   = "<option value=''>Selecione um professor</option>";
    var htmlInstituicao = "<option value=''>Selecione uma instituição</option>";


    // Percorrendo o array de situacaoaluno
    for(var i = 0; i < dados['situacaoaluno'].length; i++) {
        // Criando as options
        htmlSituacao += "<option value='" + dados['situacaoaluno'][i].id + "'>"  + dados['situacaoaluno'][i].nome + "</option>";
    }

    // Percorrendo o array de professor
    for(var i = 0; i < dados['professor'].length; i++) {
        // Criando as options
        htmlProfessor += "<option value='" + dados['professor'][i].id + "'>"  + dados['professor'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de situacao aluno
    $("#situacao_id option").remove();
    $("#situacao_id").append(htmlSituacao);

    // Removendo e adicionando as options de Professor orientador
    $("#professor_orientador_id option").remove();
    $("#professor_orientador_id").append(htmlProfessor);

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
                html += "<option value='" + retorno[0].curriculo_id + "'>"  + retorno[0].nome_curso + "</option>";
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
                html += "<option value='" + retorno[0].id + "'>"  + retorno[0].codigo + "</option>";
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

    // Monografia / Gerais
    $("#titulo").val("");
    $("#nota_final").val("");
    $("#madia").val("");
    $("#media_conceito").val("");
    $("#defendeu").val("");
    $("#professor_orientador_id").find("option:selected").removeAttr("selected");
    $("#defesa").val("");

    // Monografia / Banca examinadora
    $("#professor_banca_1_id").find("option:selected").removeAttr("selected");
    $("#professor_banca_2_id").find("option:selected").removeAttr("selected");
    $("#professor_banca_3_id").find("option:selected").removeAttr("selected");
    $("#professor_banca_4_id").find("option:selected").removeAttr("selected");
    $("#inst_ensino_banca_1_id").find("option:selected").removeAttr("selected");
    $("#inst_ensino_banca_2_id").find("option:selected").removeAttr("selected");
    $("#inst_ensino_banca_3_id").find("option:selected").removeAttr("selected");
    $("#inst_ensino_banca_4_id").find("option:selected").removeAttr("selected");

    // Formatura
    $("#data_conclusao").val("");
    $("#data_colacao").val("");
}

// Recuperando os valores dos campos
function getValueFields()
{
    // Iniciais
    var turma_id                = $("#turma_id").val();
    var situacao_id             = $("#situacao_id").val();

    // Monografia / Gerais
    var titulo                  = $("#titulo").val();
    var nota_final              = $("#nota_final").val();
    var madia                   = $("#madia").val();
    var media_conceito          = $("#media_conceito").val();
    var defendeu                = $("#defendeu").val();
    var professor_orientador_id = $("#professor_orientador_id").val();
    var defesa                  = $("#defesa").val();

    // Monografia / Banca examinadora
    var professor_banca_1_id    = $("#professor_banca_1_id").val();
    var professor_banca_2_id    = $("#professor_banca_2_id").val();
    var professor_banca_3_id    = $("#professor_banca_3_id").val();
    var professor_banca_4_id    = $("#professor_banca_4_id").val();
    var inst_ensino_banca_1_id  = $("#inst_ensino_banca_1_id").val();
    var inst_ensino_banca_2_id  = $("#inst_ensino_banca_2_id").val();
    var inst_ensino_banca_3_id  = $("#inst_ensino_banca_3_id").val();
    var inst_ensino_banca_4_id  = $("#inst_ensino_banca_4_id").val();

    // Formatura
    var data_conclusao          = $("#data_conclusao").val();
    var data_colacao            = $("#data_colacao").val();

    // Preparando os dados
    var dados = {
        'aluno_id'                : idAluno,
        'turma_id'                : turma_id == "" ? null : turma_id,
        'situacao_id'             : situacao_id == "" ? null : situacao_id,
        'titulo'                  : titulo,
        'nota_final'              : nota_final,
        'madia'                   : madia,
        'media_conceito'          : media_conceito,
        'defendeu'                : defendeu,
        'professor_orientador_id' : professor_orientador_id == "" ? null : professor_orientador_id,
        'defesa'                  : defesa,
        'professor_banca_1_id'    : professor_banca_1_id == "" ? null : professor_banca_1_id,
        'professor_banca_2_id'    : professor_banca_2_id == "" ? null : professor_banca_2_id,
        'professor_banca_3_id'    : professor_banca_3_id == "" ? null : professor_banca_3_id,
        'professor_banca_4_id'    : professor_banca_4_id == "" ? null : professor_banca_4_id,
        'inst_ensino_banca_1_id'  : inst_ensino_banca_1_id == "" ? null : inst_ensino_banca_1_id,
        'inst_ensino_banca_2_id'  : inst_ensino_banca_2_id == "" ? null : inst_ensino_banca_2_id,
        'inst_ensino_banca_3_id'  : inst_ensino_banca_3_id == "" ? null : inst_ensino_banca_3_id,
        'inst_ensino_banca_4_id'  : inst_ensino_banca_4_id == "" ? null : inst_ensino_banca_4_id,
        'data_conclusao'          : data_conclusao,
        'data_colacao'            : data_colacao
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
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            loadTableCursoTurma(idAluno);
            clearValueFields();
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });

});