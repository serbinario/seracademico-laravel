// Variável que armazenará o id da nota
var idAlunoNota;

// Evento para chamar o modal de editar notas
$(document).on("click", "#btnEditarNotas", function () {
    idAlunoNota = tableNotas.row($(this).parent().parent().index()).data().idAlunoNota;
    loadFieldsNotasEditar();
});

// carregando todos os campos preenchidos
function loadFieldsNotasEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'SituacaoNota'
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
            builderHtmlFieldsNotasEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-notas-editar').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsNotasEditar (dados) {
    // Fazendo a requisição para recuperar os dados do curriculoDisciplina
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/turma/notas/edit/' + idAlunoNota,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            // Variáveis que armazenaram o html
            var htmlSituacao  = "";

            // Percorrendo o array de situacaonota
            for (var i = 0; i < dados['situacaonota'].length; i++) {
                htmlSituacao += "<option value='" + dados['situacaonota'][i].id + "'>" + dados['situacaonota'][i].nome + "</option>";
            }

            // Preenchendo o select de situacaonota
            $("#situacao_id_editar option").remove();
            $("#situacao_id_editar").append(htmlSituacao);


            // Setando os valores do model no formulário
            $('#situacao_id_editar').find('option[value=' + retorno.data.situacao_id + ']').attr('selected', true);
            $('#nomePessoa').val(retorno.data.nomePessoa).prop('disabled', true);
            $('#nota_unidade_1').val(retorno.data.nota_unidade_1);
            $('#nota_unidade_2').val(retorno.data.nota_unidade_2);
            $('#nota_2_chamada').val(retorno.data.nota_2_chamada);
            $('#nota_final').val(retorno.data.nota_final);
            $('#nota_media').val(retorno.data.nota_media);
            $('#total_falta').val(retorno.data.total_falta).prop('disabled', true);


            // Abrindo o modal de inserir disciplina
            $("#modal-editar-notas").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdateNotas').click(function() {
    // Recuperando valores do formulário
    var situacao_id    = $("#situacao_id_editar").val();
    var nota_unidade_1 = $("#nota_unidade_1").val();
    var nota_unidade_2 = $("#nota_unidade_2").val();
    var nota_2_chamada = $("#nota_2_chamada").val();
    var nota_final     = $("#nota_final").val();
    var nota_media     = $("#nota_media").val();

    // Preparando o array de dados
    var dados = {
        'situacao_id': situacao_id,
        'nota_unidade_1': nota_unidade_1,
        'nota_unidade_2' : nota_unidade_2,
        'nota_2_chamada' : nota_2_chamada,
        'nota_final' : nota_final,
        'nota_media' : nota_media
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/turma/notas/update/' + idAlunoNota,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableNotas.ajax.reload();
            $('#modal-editar-notas').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});