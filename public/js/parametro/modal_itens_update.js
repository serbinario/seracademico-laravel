// Id item parametro
var idItemParametro;

// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#btnEditarItensParametros", function () {
    idItemParametro = tableItens.row($(this).parent().parent().parent().parent().parent().index()).data().id;
    builderHtmlFieldsEditar();
});


// Função a montar o html
function builderHtmlFieldsEditar (dados) {
    // Fazendo a requisição para recuperar os dados do curriculoDisciplina
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/parametro/itens/edit/' + idItemParametro,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            // Setando os valores do model no formulário
            $('#lbValor').text(retorno.dados.nome);
            $('#valor').val(retorno.dados.valor);

            // Abrindo o modal de inserir disciplina
            $("#modal-itens-update").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdateItensParametros').click(function() {
    var valor = $("#valor").val();

    var dados = {
        'valor': valor
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/parametro/itens/update/' + idItemParametro,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableItens.ajax.reload();
            $("#modal-itens-update").modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});