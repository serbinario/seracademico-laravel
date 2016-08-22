// Id do pivot de curriculo e disciplina
var idDebito;

// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#btnEditDebitosAbertos", function () {
    idDebito = tableDebitosAbertos.row($(this).parent().parent().parent().parent().parent().index()).data().id;
    loadFieldsDebitosEditar();
});

// carregando todos os campos preenchidos
function loadFieldsDebitosEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Financeiro\\FormaPagamento',
            'Financeiro\\LocalPagamento',
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/vestibulando/financeiro/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {// validado as disciplinas do currículo
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsDebitosEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-debitos-abertos-update').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDebitosEditar (dados) {
    // Fazendo a requisição para recuperar os dados do curriculoDisciplina
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/vestibulando/financeiro/editDebitosAbertos/' + idDebito,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            // Limpando os campos
            $('#pago').prop('checked', false);
            $('#vencimento_editar').val("");
            $('#valor_debito_editar').val("");
            $('#valor_desconto_editar').val("");
            $('#observacao_editar').val("");
            $("#valor_pago_edit").val("");

            // Variáveis que armazenaram o html
            var htmlLocalPagamento = "<option value=''>Selecione um Local</option>";
            var htmlFormaPagamento = "<option value=''>Selecione uma Forma</option>";

            // Percorrendo o array de localpagamento
            for(var i = 0; i < dados['financeiro\\localpagamento'].length; i++) {
                // Criando as options
                htmlLocalPagamento += "<option value='" + dados['financeiro\\localpagamento'][i].id + "'>"  + dados['financeiro\\localpagamento'][i].nome + "</option>";
            }

            // Percorrendo o array de formapagamento
            for(var i = 0; i < dados['financeiro\\formapagamento'].length; i++) {
                // Criando as options
                htmlFormaPagamento += "<option value='" + dados['financeiro\\formapagamento'][i].id + "'>"  + dados['financeiro\\formapagamento'][i].nome + "</option>";
            }

            // Removendo e adicionando as options de localpagamento
            $("#local_pagamento_id_edit option").remove();
            $("#local_pagamento_id_edit").append(htmlLocalPagamento);

            // Removendo e adicionando as options de formapagamento
            $("#forma_pagamento_id_edit option").remove();
            $("#forma_pagamento_id_edit").append(htmlFormaPagamento);

            // Setando os valores do model no formulário
            $('#forma_pagamento_id_edit option[value=' +  retorno.data.debito.forma_pagamento_id + ']').prop('selected', true);
            $('#local_pagamento_id_edit option[value=' +  retorno.data.debito.local_pagamento_id + ']').prop('selected', true);
            $("#valor_multa_edit").val(retorno.data.debito.valor_multa);
            $("#valor_juros_edit").val(retorno.data.debito.valor_juros);

            // Verificando se já existe uma data cadastrada
            if(retorno.data.debito.data_pagamento) {
                $("#data_pagamento_edit").val(retorno.data.debito.data_pagamento);
            }

            // Veificando se existe valor pago
            if(retorno.data.debito.valor_pago) {
                $("#valor_pago_edit").val(retorno.data.debito.valor_pago);
            } else {
                $("#valor_pago_edit").val(retorno.data.taxaValor);
            }

            // Setando os valores do model no formulário
            $('#tipo_taxa_id_editar').html('<option value="' + retorno.data.tipoTaxaId + '">'  + retorno.data.tipoTaxaNome + '</option>');
            $('#taxa_id_editar').html('<option value="' + retorno.data.taxaId + '">'  + retorno.data.taxaNome + '</option>');
            $('#valor_taxa_vestibulando_editar').val(retorno.data.taxaValor);
            $('#vencimento_editar').val(retorno.data.vencimento);
            $('#valor_debito_editar').val(retorno.data.taxaValor);
            $('#valor_desconto_editar').val(retorno.data.valor_desconto);
            $('#mes_referencia_editar').val(retorno.data.mes_referencia);
            $('#ano_referencia_editar').val(retorno.data.ano_referencia);
            $('#observacao_editar').val(retorno.data.observacao);

            // Tratando a baixa
            if(retorno.data.pago == 1) {
                $('#pago').attr('checked', true).attr('disabled', true);
            }

            // Abrindo o modal de inserir disciplina
            $("#modal-debitos-abertos-update").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnDebitosAbertosUpdate').click(function() {
    // Calcular o valor totla
    calculoValorTotal();

    // Recuperando os valores
    var forma_pagamento_id = $("#forma_pagamento_id_edit").val();
    var local_pagamento_id = $("#local_pagamento_id_edit").val();
    var observacao         = $("#observacao_editar").val();
    var valor_pago         = $("#valor_pago_edit").val();
    var valor_multa        = $("#valor_multa_edit").val();
    var valor_juros        = $("#valor_juros_edit").val();
    var data_pagamento     = $("#data_pagamento_edit").val();
    var taxa_id            = $("#taxa_id_editar").val();
    var valor_debito       = $("#valor_debito_editar").val();
    var valor_desconto     = $("#valor_desconto_editar").val();
    var vencimento         = $('#vencimento_editar').val();
    var mes_referencia     = $('#mes_referencia_editar').val();
    var ano_referencia     = $('#ano_referencia_editar').val();
    var observacao         = $('#observacao_editar').val();
    var pago               = $('#pago:checked').val();

    // Dados ajax
    var dados = {
        'data_pagamento': data_pagamento,
        'observacao': observacao,
        'valor_multa' : valor_multa,
        'valor_juros' : valor_juros,
        'forma_pagamento_id': forma_pagamento_id,
        'local_pagamento_id': local_pagamento_id,
        'valor_pago': valor_pago,
        'vestibulando_id' : idVestibulando,
        'taxa_id' : taxa_id,
        'valor_debito' : valor_debito,
        'valor_desconto' : valor_desconto,
        'vencimento' : vencimento,
        'mes_referencia': mes_referencia,
        'ano_referencia': ano_referencia,
        'observacao': observacao,
        'pago': pago
    };
    
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibulando/financeiro/updateDebitosAbertos/' + idDebito,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDebitosAbertos.ajax.reload();
            tableDebitosPagos.ajax.reload();
            table.ajax.reload();

            $('#modal-debitos-abertos-update').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para remover débito
$(document).on("click", "#btnRemoveDebitosAbertos", function () {
    idDebito = tableDebitosAbertos.row($(this).parent().parent().parent().parent().parent().index()).data().id;

    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/vestibulando/financeiro/deleteDebitosAbertos/' + idDebito,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDebitosAbertos.ajax.reload();
            table.ajax.reload();
            
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para mudança de valor
$('#valor_desconto_editar').on('focusout', function() {
    //Calcular o valor total
    calculoValorTotal();
});

// Evento para mudança de valor
// $('#valor_juros_edit').on('focusout', function() {
//     //Calcular o valor total
//     calcularValorJurosEdit();
// });
//
// // Evento para mudança de valor
// $('#valor_multa_edit').on('focusout', function() {
//     //Calcular o valor total
//     calcularValorMultaEdit();
// });
//
// // Variáveis que armazenarão valores antigos de multa e juros
// var valorMultaEditOld = 0, valorJurosEditOld = 0;
//
// // Evento para mudança de valor
// $('#valor_juros_edit').on('focus', function() {
//     //Calcular o valor total
//     valorJurosEditOld = Number($('#valor_pago_edit').val()) - Number($(this).val());
// });
//
// // Evento para mudança de valor
// $('#valor_multa_edit').on('focus', function() {
//     //Calcular o valor total
//     valorMultaOld = Number($('#valor_pago').val()) - Number($(this).val());
// });

// Método para dar baixa no débito em aberto
$(document).on('click', '#btnCloseDebitoAberto', function () {
    // Recuperando o id do débito
    idDebito = tableDebitosAbertos.row($(this).parent().parent().parent().parent().parent().index()).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'PUT',
        url: '/index.php/seracademico/vestibulando/financeiro/closeDebitoAberto/' + idDebito,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDebitosAbertos.ajax.reload();
            tableDebitosPagos.ajax.reload();
            table.ajax.reload();

            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Função para calcular o valor total
function calculoValorTotal()
{
    // variáveis de uso
    var valorDebito, valorDeconto, valorTotal, valorFinal, valorProvFinal;

    // Recebendo e tratando as entradas
    valorDeconto = Number($('#valor_desconto_editar').val());
    valorDebito  = Number($('#valor_debito_editar').val());
    valorTotal   = Number($("#valor_pago_edit").val());

    // Regra de verificação
    if(valorTotal == 0 || !valorTotal) {
        valorTotal = valorDebito;
    }

    // Validação dos valores
    if(valorDeconto > valorDebito) {
        swal('Valor de desconto tem que ser menor ou igual ao valor do débito');
        return false;
    }

    // Calculando o valor provisório final
    valorProvFinal = valorDebito - valorDeconto;

    // Regra de cálculo
    if((valorProvFinal + valorDeconto) != valorDebito) {
        valorFinal = valorProvFinal + (valorDebito - (valorProvFinal + valorDeconto));
    } else {
        valorFinal = valorProvFinal;
    }

    // Calculando o valor final
    $('#valor_pago_edit').val(valorFinal.toFixed(2)); // get the current value of the input field.
}

// Função para calcular o valor do juros
function calcularValorJurosEdit()
{
    // Variáveis úteis
    var valorJuros, valorFinal;

    // Recalculando o valor Total
    calculoValorTotal();
    calcularValorMultaEdit();

    // Recebendo e tratando as entradas
    valorJuros = Number($('#valor_juros_edit').val());
    valorFinal = Number($('#valor_pago_edit').val());

    // Setando com o novo valor
    $('#valor_pago_edit').val((valorFinal + valorJuros));
}

// Função para calcular o valor da multa
function calcularValorMultaEdit()
{
    // Variáveis úteis
    var valorMulta, valorFinal;

    // Recalculando o valor Total
    calculoValorTotal();
    calcularValorJurosEdit();

    // Recebendo e tratando as entradas
    valorMulta = Number($('#valor_multa_edit').val());
    valorFinal = Number($('#valor_pago_edit').val());

    // Setando com o novo valor
    $('#valor_pago_edit').val((valorFinal + valorMulta));
}