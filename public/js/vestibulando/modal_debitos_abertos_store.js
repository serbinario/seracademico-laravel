// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnAdicionarDebitosAbertos", function () {
    loadFieldsDebitos();
});

// carregando todos os campos preenchidos
function loadFieldsDebitos()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Financeiro\\TipoTaxa|withTaxas',
            'Financeiro\\FormaPagamento',
            'Financeiro\\LocalPagamento'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/vestibulando/financeiro/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno['financeiro\\tipotaxa'].length > 0) {
            builderHtmlFieldsDebitos(retorno);
        } else {
            // Retorno caso não matéria disponível
            swal("Desculpe não existe tipo de taxa disponível", "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDebitos (dados) {
    // limpando os campos
    $("#forma_pagamento_id option").attr('selected', false);
    $("#local_pagamento_id option").attr('selected', false);
    $('#vencimento').val("");
    $('#valor_debito').val("");
    $('#valor_desconto').val("");
    $('#valor_pago').val("");
    $('#valor_multa').val("");
    $('#valor_juros').val("");
    //$('#mes_referencia').val("");
    //$('#ano_referencia').val("");
    $('#observacao').val("");
    $('#pago_create').prop('checked', false);

    // Variáveis que armazenaram o html
    var htmlTipoTaxa = "<option value=''>Selecione um tipo</option>";
    var htmlFormPaga = "<option value=''>Selecione uma forma de pagamento</option>";
    var htmlLocaPaga = "<option value=''>Selecione um local de pagamento</option>";

    // Percorrendo o array de tipotaxa
    for(var i = 0; i < dados['financeiro\\tipotaxa'].length; i++) {
        // Criando as options
        htmlTipoTaxa += "<option value='" + dados['financeiro\\tipotaxa'][i].id + "'>" + dados['financeiro\\tipotaxa'][i].nome + "</option>";
    }

    // Percorrendo o array de formapagamento
    for(var i = 0; i < dados['financeiro\\formapagamento'].length; i++) {
        // Criando as options
        htmlFormPaga += "<option value='" + dados['financeiro\\formapagamento'][i].id + "'>" + dados['financeiro\\formapagamento'][i].nome + "</option>";
    }

    // Percorrendo o array de localpagamento
    for(var i = 0; i < dados['financeiro\\localpagamento'].length; i++) {
        // Criando as options
        htmlLocaPaga += "<option value='" + dados['financeiro\\localpagamento'][i].id + "'>" + dados['financeiro\\localpagamento'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de período
    $("#tipo_taxa_id option").remove();
    $("#tipo_taxa_id").append(htmlTipoTaxa);
    $("#forma_pagamento_id option").remove();
    $("#forma_pagamento_id").append(htmlFormPaga);
    $("#local_pagamento_id option").remove();
    $("#local_pagamento_id").append(htmlLocaPaga);

    // Abrindo o modal de inserir disciplina
    $("#modal-debitos-abertos-store").modal({show : true});
};

// evento para carregar a taxa
$(document).on('change', '#tipo_taxa_id', function () {
    // recuperando o id dataxa
    var idTipoTaxa = $(this).find('option:selected').val();

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/taxa/getTaxas',
        data: {'idTipoTaxa' : idTipoTaxa},
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // html da taxa
            var htmlTaxa = "<option value=''>Selecione uma taxa</option>";

            // Recarregando as grids
            $.each(retorno.data, function (index, value) {
                htmlTaxa += "<option value='" + value.id +"'>" + value.nome + "</option>";
            });

            // Removendo e adicionando os htmls
            $("#taxa_id option").remove();
            $("#taxa_id").append(htmlTaxa);
        } else {
            // Fechando a modal
            $('#modal-debitos-abertos-store').modal('toggle');

            // Retorno
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento quando mudar o select de taxa
$(document).on('click', '#taxa_id', function () {
    // Recuperando o id da taxa
    var taxaId = $(this).val();

    // Validando a possibilidade de requisição
    if(!taxaId) {
        return false;
    }

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/taxa/getTaxa/' + taxaId,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            $('#valor_debito').val(retorno.data.valor);
            $('#valor_pago').val(retorno.data.valor);
        } else {
            // Fechando a modal
            $('#modal-debitos-abertos-store').modal('toggle');

            // Retorno
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para salvar tabela de preços
$('#btnDebitosAbertosSalvar').click(function() {
    // Calculando o valor total
    calculoValorTotalCreate();

    // Recuperando os valores
    var forma_pagamento_id = $("#forma_pagamento_id").val();
    var local_pagamento_id = $("#local_pagamento_id").val();
    var taxa_id        = $("#taxa_id").val();
    var valor_debito   = $("#valor_debito").val();
    var valor_desconto = $("#valor_desconto").val();
    var valor_multa    = $('#valor_multa').val();
    var valor_juros    = $('#valor_juros').val();
    var valor_pago     = $('#valor_pago').val();
    var vencimento     = $('#vencimento').val();
    var data_pagamento = $('#data_pagamento').val();
    //var mes_referencia = $('#mes_referencia').val();
    //var ano_referencia = $('#ano_referencia').val();
    var observacao     = $('#observacao').val();
    var pago           = $('#pago_create:checked').val();

    // Dados ajax
    var dados = {
        'forma_pagamento_id': forma_pagamento_id,
        'local_pagamento_id': local_pagamento_id,
        'vestibulando_id' : idVestibulando,
        'taxa_id' : taxa_id,
        'valor_debito' : valor_debito,
        'valor_desconto' : valor_desconto,
        'valor_multa': valor_multa,
        'valor_juros': valor_juros,
        'valor_pago': valor_pago,
        'vencimento' : vencimento,
        'data_pagamento' : data_pagamento,
        //'mes_referencia': mes_referencia,
        //'ano_referencia': ano_referencia,
        'observacao': observacao,
        'pago': pago
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibulando/financeiro/storeDebitosAbertos',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableDebitosAbertos.ajax.reload();
            tableDebitosPagos.ajax.reload();

            // Fechando a modal
            $('#modal-debitos-abertos-store').modal('hide');

            // Retorno
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            // Retorno
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para mudança de valor
$('#valor_desconto').on('focusout', function() {
    //Calcular o valor total
    calculoValorTotalCreate();
});

// Função para calcular o valor total
function calculoValorTotalCreate()
{
    // variáveis de uso
    var valorDebito, valorDeconto, valorTotal, valorFinal, valorProvFinal;

    // Recebendo e tratando as entradas
    valorDeconto = Number($('#valor_desconto').val());
    valorDebito  = Number($('#valor_debito').val());
    valorTotal   = Number($("#valor_pago").val());

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
    $('#valor_pago').val(valorFinal.toFixed(2)); // get the current value of the input field.
}