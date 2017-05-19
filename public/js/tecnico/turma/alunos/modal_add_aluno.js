// evento para abrir modal de adicionar curso ao aluno
$(document).on("click", "#btnAddAluno", function () {
    // Carregando os campos
    loadFieldsAddAluno();

    // Exibindo o modal
    $("#modal-add-aluno").modal({show:true});
});

// carregando todos os campos preenchidos
function loadFieldsAddAluno()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Mestrado\\Curso|ativo,1',
            'Mestrado\\Disciplina|disciplinasOfTurma,' + idTurma
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/mestrado/turma/alunos/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsAddAluno(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-add-aluno').modal('toggle');
        }
    });
}

// Função a montar o html
function builderHtmlFieldsAddAluno (dados) {
    // Variáveis que armazenaram o html
    var htmlDisciplina = "<option value=''>Selecione uma Disciplina</option>";
    var htmlCurso      = "<option value=''>Selecione um Curso</option>";

    // Percorrendo o array de situacaoaluno
    for(var i = 0; i < dados['mestrado\\curso'].length; i++) {
        // Criando as options
        htmlCurso += "<option value='" + dados['mestrado\\curso'][i].id + "'>"  + dados['mestrado\\curso'][i].nome + "</option>";
    }

    // Percorrendo o array de situacaoaluno
    for(var i = 0; i < dados['mestrado\\disciplina'].length; i++) {
        // Criando as options
        htmlDisciplina += "<option value='" + dados['mestrado\\disciplina'][i].id + "'>"  + dados['mestrado\\disciplina'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de situacao aluno
    $("#add_aluno_curso option").remove();
    $("#add_aluno_curso").append(htmlCurso);
    $("#turma_disciplina_id option").remove();
    $("#turma_disciplina_id").append(htmlDisciplina);
}


// evento quando selecionar o curso
$(document).on("change", "#add_aluno_curso", function () {
    // recuperando as options
    var idCurso = $(this).val();
    var idDisciplina = $('#turma_disciplina_id').val();

    // Verificando a disciplina
    if(!idDisciplina) {
        swal('Voçê deve selecionar uma disciplina!', '', 'error');
        return false;
    }

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/mestrado/turma/alunos/getAlunosByCurso/' + idCurso + '/' + idTurma + '/' + idDisciplina,
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno.success) {
            var htmlAluno = "<option value=''>Selecione um Aluno</option>";

            // Percorrendo o array de aluno
            for(var i = 0; i < retorno.dados.length; i++) {
                // Criando as options
                htmlAluno += "<option value='" + retorno.dados[i].id + "'>"  + retorno.dados[i].nome + "</option>";
            }

            // Removendo e adicionando as options de aluno
            $("#turma_aluno_id option").remove();
            $("#turma_aluno_id").append(htmlAluno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-add-aluno').modal('toggle');
        }
    });
});

// Limpa os valores dos campos
function clearValueFields()
{
    // Iniciais
    $("#turma_aluno_id option").remove();
}

// Recuperando os valores dos campos
function getValueFields()
{
    // Iniciais
    var aluno_id = $("#turma_aluno_id").val();
    var disciplina_id = $("#turma_disciplina_id").val();

    // Verificando a disciplina
    if(!disciplina_id || !aluno_id) {
        swal('Voçê deve selecionar a disciplina e o aluno!', '', 'error');
        return false;
    }

    // Preparando os dados
    var dados = {
        'aluno_id' : aluno_id,
        'disciplina_id' : disciplina_id,
        'turma_id': idTurma
    };

    // Retorno
    return dados;
}

// Evento de click do botão de salvar turma do aluno
$(document).on("click", "#btnSaveAddAluno", function () {
    // Recuperando os valores dos formulários
    var dados = getValueFields();

    // Transação com banco de dados
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/mestrado/turma/alunos/attachAluno',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableAlunos.ajax.reload();

            // Limpando os campos
            clearValueFields();

            // Fechando o modal
            $("#modal-add-aluno").modal('toggle');

            // Mensagem de retorno
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });

});