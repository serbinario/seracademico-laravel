// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnAddSituacao", function () {
    loadFieldsSituacao();
});

// Evento quando fechar a modal
$(document).on('click', '#closeModalHistorico', function () {
    $("#btnAddSituacao").prop("disabled", true);
    loadTableSituacao(0).ajax.url("/index.php/seracademico/graduacao/aluno/historico/situacao/grid/" + 0).load();
});

// carregando todos os campos preenchidos
function loadFieldsSituacao()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Curso|byCurriculoAtivo,1',
            'SituacaoAluno'
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
            builderHtmlFieldsSituacao(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-historico').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsSituacao (dados) {
    //Limpando os campos
    $('#curso_destino_id option').attr('selected', false).parent().prop('disabled', true);
    $('#situacao_id option').attr('selected', false);
    $('#observacao').val('');

    // Variáveis que armazenaram o html
    var htmlSituacao  = "";
    var htmlCurso     = "";

    // Percorrendo o array de cursos
    for (var i = 0; i < dados['situacaoaluno'].length; i++) {
        htmlSituacao += "<option value='" + dados['situacaoaluno'][i].id + "'>" + dados['situacaoaluno'][i].nome + "</option>";

    }

    // Percorrendo o array de cursos
    for (var i = 0; i < dados['graduacao\\curso'].length; i++) {
        htmlCurso += "<option value='" + dados['graduacao\\curso'][i].id + "'>" + dados['graduacao\\curso'][i].nome + "</option>";

    }

    // carregando o html
    $("#situacao_id option").remove();
    $("#situacao_id").append(htmlSituacao);

    // carregando o html
    $("#curso_destino_id option").remove();
    $("#curso_destino_id").append(htmlCurso);

    // Abrindo o modal de inserir disciplina
    $("#modal-create-situacao").modal({show : true});
}

// Evento para mudança de curso
$(document).on('change', '#situacao_id', function () {
    // Recuperando o valor da
    var valor = $(this).find('option:selected').val();

    // Verificando se foi escolhido mudança de curso
    if(valor == 3) {
        $('#curso_destino_id').prop('disabled', false);
    } else {
        $('#curso_destino_id').prop('disabled', true);
    }
});

// Evento para salvar tabela de preços
$('#btnSaveSituacao').click(function() {
    //var curso_id  = $("#curso_id").val();
    var situacao_id  = $("#situacao_id option:selected").val();
    var observacao   = $("#observacao").val();
    var curso_destino_id = $("#curso_destino_id:enabled option:selected").val();

    // Dados de envio
    var dados = {
        'situacao_id' : situacao_id,
        'aluno_id' : idAluno,
        'observacao' : observacao,
        'curso_destino_id' : curso_destino_id
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/historico/situacao/save/' + idSemestre,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            table.ajax.reload();
            tableSituacao.ajax.reload();
            tableHistorico.ajax.reload(function () {
                tableHistorico.row(indexRowSelectedHistorico).nodes().to$().find('td').addClass("row_selected");
             });

            // fechando a modal
            $('#modal-create-situacao').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDeleteSituacao', function () {
    // recuperando o id do aluno_semestre
    var idAlunoSituacao = tableSituacao.row($(this).parent().parent().index()).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/historico/situacao/delete/' + idAlunoSituacao,
        datatype: 'json'
    }).done(function (retorno) {
        table.ajax.reload();
        tableSituacao.ajax.reload();
        tableHistorico.ajax.reload(function () {
            tableHistorico.row(indexRowSelectedHistorico).nodes().to$().find('td').addClass("row_selected");
        });

        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});