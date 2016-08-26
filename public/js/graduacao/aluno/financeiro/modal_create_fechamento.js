// variável que armazenará o id do débito
var idDebitoAberto;

// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnCreateFechamento", function () {
    // Recuperando o id do débito
    idDebitoAberto = tableDebitosAbertos.row($(this).parent().parent().parent().parent().parent().index()).data().id;

    // Verificando se o id foi recuperado
    if(idDebitoAberto) {
        loadFieldsFechamento();
    } else {
        swal('Débito não encontrado', "Click no botão abaixo!", "error");
    }
});

// carregando todos os campos preenchidos
function loadFieldsFechamento()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Financeiro\\FormaPagamento',
            'Financeiro\\LocalPagamento'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        data: dados,
        url: '/index.php/seracademico/financeiro/aluno/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFechamento(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-historico').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFechamento (dados) {
    //Limpando os campos
    $('#forma_pagamento_id option').attr('selected', false);
    $('#local_pagamento_id option').attr('selected', false);
    $('#valor_parcela').val('');
    $('#valor_pago').val('');
    $('#valor_debito_fechamento').val('');
    $('#data_vencimento_fechamento').val('');
    $('#data_fechamento').val('');
    $('#valor_juros_fechamento').val('');
    $('#valor_tipo_juros').val('');
    $('#valor_multa_fechamento').val('');
    $('#valor_tipo_multa').val('');
    $('#valor_desconto_fechamento').val('');
    $('#valor_tipo_desconto').val('');
    $('#valor_acrescimo').val('');
    $('#valor_tipo_acrescimo').val('');
    $('#valor_descrecimo').val('');
    $('#valor_tipo_descrecimo').val('');
    $('#valor_total').val('');

    // Variáveis que armazenaram o html
    var htmlFormaPagamento = "";
    var htmlLocalPagamento = "";

    // Percorrendo o array de formas de pagamentos
    for (var i = 0; i < dados['financeiro\\formapagamento'].length; i++) {
        htmlFormaPagamento += "<option value='" + dados['financeiro\\formapagamento'][i].id + "'>" + dados['financeiro\\formapagamento'][i].nome + "</option>";
    }

    // Percorrendo o array de locais de pagamentos
    for (var i = 0; i < dados['financeiro\\localpagamento'].length; i++) {
        htmlLocalPagamento += "<option value='" + dados['financeiro\\localpagamento'][i].id + "'>" + dados['financeiro\\localpagamento'][i].nome + "</option>";
    }

    // Carregado os selects
    $("#forma_pagamento_id option").remove();
    $("#forma_pagamento_id").append(htmlFormaPagamento);
    $("#local_pagamento_id option").remove();
    $("#local_pagamento_id").append(htmlLocalPagamento);

    // Carregando os valores padrões do formulário
    getInfoDebitoAberto(idDebitoAberto);

    // Abrindo o modal de inserir disciplina
    $("#modal-create-fechamento").modal({show : true});
}

// Evento para salvar histórico
$('#btnSaveFechamento').click(function() {
    var forma_pagamento_id    = $("#forma_pagamento_id option:selected").val();
    var local_pagamento_id    = $("#local_pagamento_id option:selected").val();
    var data_fechamento       = $("#data_fechamento").val();
    var valor_juros           = $("#valor_juros_fechamento").val();
    var valor_tipo_juros      = $("#valor_tipo_juros").val();
    var valor_multa           = $("#valor_multa_fechamento").val();
    var valor_tipo_multa      = $("#valor_tipo_multa").val();
    var valor_desconto        = $("#valor_desconto_fechamento").val();
    var valor_tipo_desconto   = $("#valor_tipo_desconto").val();
    var valor_acrescimo       = $("#valor_acrescimo").val();
    var valor_tipo_acrescimo  = $("#valor_tipo_acrescimo").val();
    var valor_descrecimo      = $("#valor_descrecimo").val();
    var valor_tipo_descrecimo = $("#valor_tipo_descrecimo").val();
    var valor_total           = $("#valor_total").val();

    var dados = {
        'debito_id' : idDebitoAberto,
        'forma_pagamento_id' : forma_pagamento_id,
        'local_pagamento_id' : local_pagamento_id,
        'data_fechamento': data_fechamento,
        'valor_juros': valor_juros,
        'valor_tipo_juros' : valor_tipo_juros,
        'valor_multa' : valor_multa,
        'valor_tipo_multa' : valor_tipo_multa,
        'valor_desconto' : valor_desconto,
        'valor_tipo_desconto' : valor_tipo_desconto,
        'valor_acrescimo': valor_acrescimo,
        'valor_tipo_acrescimo': valor_tipo_acrescimo,
        'valor_descrecimo' : valor_descrecimo,
        'valor_tipo_descrecimo' : valor_tipo_descrecimo,
        'valor_total' : valor_total
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/aluno/storeFechamento',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDebitosAbertos.ajax.reload();
            tableDebitosFechados.ajax.reload();

            $('#modal-create-fechamento').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});


/**
 * Função responsável por recuperar o débito e
 * preencher os campos de cadastro.
 *
 * @param idTaxa
 */
function getInfoDebitoAberto(idDebitoAberto)
{
    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/aluno/getDebitoAberto/' + idDebitoAberto,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Formatando os campos
            $('#valor_parcela').val(retorno.data.taxa.valor);
            $('#valor_debito_fechamento').val(retorno.data.valor_debito);
            $('#data_vencimento_fechamento').val(retorno.data.data_vencimento);
            $('#valor_tipo_juros').val(retorno.data.taxa.valor_juros);
            $('#valor_tipo_multa').val(retorno.data.taxa.valor_multa);
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

//// Evento para o click no botão de remover disciplina
//$(document).on('click', '#btnDeleteHistorico', function () {
//    // recuperando o id do aluno_semestre
//    var idAlunoSemestre = tableHistorico.row($(this).parent().parent().index()).data().idAlunoSemestre;
//
//    // Requisição ajax
//    jQuery.ajax({
//        type: 'POST',
//        url: '/index.php/seracademico/graduacao/aluno/historico/delete/' + idAlunoSemestre,
//        datatype: 'json'
//    }).done(function (retorno) {
//        table.ajax.reload();
//        tableHistorico.ajax.reload();
//        swal(retorno.msg, "Click no botão abaixo!", "success");
//    });
//});