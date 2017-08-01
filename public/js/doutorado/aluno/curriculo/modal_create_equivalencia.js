// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnAddEquivalencia", function () {
    loadFieldsAddEquivalencia();
});

// carregando todos os campos preenchidos
function loadFieldsAddEquivalencia()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Doutorado\\Curriculo|lessOfAluno,' + idAluno,
            'Doutorado\\Disciplina|curriculoByAluno,' + idAluno
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/doutorado/aluno/turma/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsAddEquivalencia(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-equivalencia').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsAddEquivalencia (dados) {
    //Limpando os campos
    $('#equivalencia_disciplina_id option').attr('selected', false);
    $('#curriculo_equivalencia_id option').attr('selected', false);
    $('#disciplina_equivalencia_id option').remove();

    // Variáveis que armazenaram o html
    var htmlCurriculo  = "<option value=''>Selecione um currículo</option>";
    var htmlDisciplina = "<option value=''>Selecione uma Disciplina</option>";

    // Percorrendo o array de cursos
    for (var i = 0; i < dados['doutorado\\curriculo'].length; i++) {
        htmlCurriculo += "<option value='" + dados['doutorado\\curriculo'][i].id + "'>"
            + dados['doutorado\\curriculo'][i].codigo +  ' : ' + dados['doutorado\\curriculo'][i].nome + "</option>";
    }

    // Percorrendo o array de disciplinas
    for (var i = 0; i < dados['doutorado\\disciplina'].length; i++) {
        htmlDisciplina += "<option value='" + dados['doutorado\\disciplina'][i].id + "'>"
            + dados['doutorado\\disciplina'][i].codigo +  ' : ' + dados['doutorado\\disciplina'][i].nome + "</option>";
    }

    // carregando o html
    $("#curriculo_equivalencia_id option").remove();
    $("#curriculo_equivalencia_id").append(htmlCurriculo);
    $("#equivalencia_disciplina_id option").remove();
    $("#equivalencia_disciplina_id").append(htmlDisciplina);

    // Abrindo o modal de inserir disciplina extra curricular do aluno
    $("#modal-create-equivalencia").modal({show : true});
}

// Evento para mudança de curriculo
$(document).on('change', '#curriculo_equivalencia_id', function () {
    // Recuperando o valor da
    var idCurriculo = $(this).find('option:selected').val();

    // Validando o valor do id
    if(idCurriculo == '') {
        return false;
    }

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/doutorado/aluno/curriculo/getDisciplinasByCurriculo/' + idCurriculo,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Variável que armazenará o html
            var htmlDisciplina = "<option>Selecione uma disciplina</option>";

            // Percorrendo o array de disciplinas
            for (var i = 0; i < retorno.dados.length; i++) {
                htmlDisciplina += "<option value='" + retorno.dados[i].id + "'>" + retorno.dados[i].codigo  + ' : ' + retorno.dados[i].nome + "</option>";
            }

            // Atualizando o dom
            $('#disciplina_equivalencia_id option').remove();
            $('#disciplina_equivalencia_id').append(htmlDisciplina);
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para salvar tabela de disciplinas extras curriculares dos alunos
$('#btnSaveEquivalencia').click(function() {
    // Recuperando os valores do formulário
    var curriculo_id   = $("#curriculo_equivalencia_id option:selected").val();
    var disciplina_equivalente_id  = $("#disciplina_equivalencia_id option:selected").val();
    var equivalencia_disciplina_id = $("#equivalencia_disciplina_id option:selected").val();

    // Validando os dados de entrada
    if(!curriculo_id && !disciplina_id) {
        swal('Ocorreu um erro', 'Você deve informar o currículo e a disciplina', 'danger');
    }

    // Dados de envio
    var dados = {
        'curriculo_id' : curriculo_id,
        'disciplina_equivalente_id' : disciplina_equivalente_id,
        'disciplina_id' : equivalencia_disciplina_id,
        'pos_aluno_curso_id' : idAlunoCurso
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/doutorado/aluno/curriculo/storeEquivalencia',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableDisciplinasACursar.ajax.reload();
            tableDisciplinasEquivalentes.ajax.reload();

            // fechando a modal
            $('#modal-create-equivalencia').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});


// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDeleteEquivalencia', function () {
    var idDicilinaEquivalente = tableDisciplinasEquivalentes.row($(this).parents('tr')).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/doutorado/aluno/curriculo/deleteEquivalencia/' + idDicilinaEquivalente,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDisciplinasEquivalentes.ajax.reload();
            tableDisciplinasACursar.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});