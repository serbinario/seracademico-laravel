// Evento para chamar o modal de editar notas
$(document).on("click", "#btnEditarDisciplina", function () {
    var idDisciplina = tableDisciplina.row($(this).parent().parent().index()).data().idDisciplina;
    loadFieldsDisciplinaEditar(idDisciplina);
});

// carregando todos os campos preenchidos
function loadFieldsDisciplinaEditar(idDisciplina)
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Disciplina|getId,' + idDisciplina
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/turma/notas/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsDisciplinaEditar(retorno, idDisciplina);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-disciplina-edit').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDisciplinaEditar (dados, idDisciplina) {
    // Limpando os campos
    $('#eletiva_editar').find('option:selected').attr('selected', false);

    // Fazendo a requisição para recuperar os dados do curriculoDisciplina
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/turma/disciplina/edit/' + idTurma + '/' + idDisciplina,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            // Variáveis que armazenaram o html
            var htmlDisciplina  = "";

            // Percorrendo o array de situacaonota
            for (var i = 0; i < dados['graduacao\\disciplina'].length; i++) {
                htmlDisciplina += "<option value='" + dados['graduacao\\disciplina'][i].id + "'>" + dados['graduacao\\disciplina'][i].nome + "</option>";
            }

            // Preenchendo o select de situacaonota
            $("#disciplina_editar_id option").remove();
            $("#disciplina_editar_id").append(htmlDisciplina);

            // Setando os valores do model no formulário
            if(retorno.dados.eletiva) {
                $('#eletiva_editar').find('option:eq(1)').prop('selected', true);
            } else {
                $('#eletiva_editar').find('option:eq(0)').prop('selected', true);
            }

            // Abrindo o modal de inserir disciplina
            $("#modal-disciplina-edit").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdateDisciplinaTurma').click(function() {
    // Recuperando valores do formulário
    var eletiva    = $("#eletiva_editar").val();
    var disciplina = $("#disciplina_editar_id").val();

    // Preparando o array de dados
    var dados = {
        'eletiva': eletiva
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/turma/disciplina/update/' + idTurma + '/' + disciplina,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDisciplina.ajax.reload();
            $('#modal-disciplina-edit').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});