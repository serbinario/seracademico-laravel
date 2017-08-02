// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnAddDisciplinaExtraCurricular", function () {
    loadFieldsAddDisciplinaExtraCurricular();
});

// carregando todos os campos preenchidos
function loadFieldsAddDisciplinaExtraCurricular()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Doutorado\\Curriculo|lessOfAluno,' + idAluno
        ]
    };
console.log(dados);
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/doutorado/aluno/turma/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsAddDisciplinaExtraCurricular(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-disciplina-extra-curricular').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsAddDisciplinaExtraCurricular (dados) {
    //Limpando os campos
    $('#curriculo_extra_curricular_id option').attr('selected', false);
    $('#disciplina_extra_curricular_id option').remove();

    // Variáveis que armazenaram o html
    var htmlCurriculo  = "<option value=''>Selecione um currículo</option>";

    // Percorrendo o array de cursos
    for (var i = 0; i < dados['doutorado\\curriculo'].length; i++) {
        htmlCurriculo += "<option value='" + dados['doutorado\\curriculo'][i].id + "'>"
            + dados['doutorado\\curriculo'][i].codigo +  ' : ' + dados['doutorado\\curriculo'][i].nome + "</option>";
    }

    // carregando o html
    $("#curriculo_extra_curricular_id option").remove();
    $("#curriculo_extra_curricular_id").append(htmlCurriculo);

    // Abrindo o modal de inserir disciplina extra curricular do aluno
    $("#modal-create-disciplina-extra-curricular").modal({show : true});
}

// Evento para mudança de curriculo
$(document).on('change', '#curriculo_extra_curricular_id', function () {
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
            $('#disciplina_extra_curricular_id option').remove();
            $('#disciplina_extra_curricular_id').append(htmlDisciplina);
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para salvar tabela de disciplinas extras curriculares dos alunos
$('#btnSaveDisciplinaExtraCurricular').click(function() {
    // Recuperando os valores do formulário
    var curriculo_id   = $("#curriculo_extra_curricular_id option:selected").val();
    var disciplina_id  = $("#disciplina_extra_curricular_id option:selected").val();

    // Validando os dados de entrada
    if(!curriculo_id && !disciplina_id) {
        swal('Ocorreu um erro', 'Você deve informar o currículo e a disciplina', 'danger');
    }

    // Dados de envio
    var dados = {
        'curriculo_id' : curriculo_id,
        'disciplina_id' : disciplina_id,
        'pos_aluno_curso_id' : idAlunoCurso
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/doutorado/aluno/curriculo/storeDisciplinaExtraCurricular',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableDisciplinasACursar.ajax.reload();
            tableDisciplinasExtraCurricular.ajax.reload();

            // fechando a modal
            $('#modal-create-disciplina-extra-curricular').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDeleteDisciplinaExtraCurricular', function () {
    var idDicilinaExtraCurricular = tableDisciplinasExtraCurricular.row($(this).parents('tr')).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/doutorado/aluno/curriculo/deleteDisciplinaExtraCurricular/' + idDicilinaExtraCurricular,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableDisciplinasACursar.ajax.reload();
            tableDisciplinasExtraCurricular.ajax.reload();

            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});