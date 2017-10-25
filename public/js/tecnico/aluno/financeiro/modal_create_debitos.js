$(document).on("click", "#btnModalCreateDebitos", function () {
    loadFieldsDebito();
});


function loadFieldsDebito()
{
    var dados =  {
        'models' : [
            'Financeiro\\Taxa',
            'Financeiro\\ContaBancaria',
            'Financeiro\\FormaPagamento'
        ]
    };

    jQuery.ajax({
        type: 'GET',
        data: dados,
        url: '/index.php/seracademico/tecnico/aluno/financeiro/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno) {
            builderHtmlFieldsDebito(retorno);
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-historico').modal('toggle');
        }
    });
};


function preencheCamposTaxa (retorno) {
    if (retorno.success) {
        var now = new Date();
        var dataVencimento = (retorno.data.dia_vencimento
                ? retorno.data.dia_vencimento
                : now.getDate()) + "/" + (now.getMonth() + 1) + "/" + now.getFullYear();

        $('#valor_taxa').val(retorno.data.valor);
        $('#valor_debito').val(retorno.data.valor);
        $('#data_vencimento').val(dataVencimento);
    } else {
        swal(
            'O preenchimento automático dos campos pela taxa não pode ser concluído',
            'Click no botão abaixo!',
            'error'
        );
    }
}

function builderHtmlFieldsDebito (dados) {
    $('#taxa_id option').prop('selected', false);
    $('#conta_bancaria_id option').prop('selected', false);
    $('#pago option').prop('selected', false);
    $('#gerar_care option').prop('selected', false);
    $('#data_vencimento').val('');
    $('#valor_taxa').val('');
    $('#valor_debito').val('');
    $('#mes_referencia').val('');
    $('#ano_referencia').val('');

    var htmlTaxa = "";
    var htmlContaBancaria = "";
    var htmlFormaPagamento = "<option value=''>Selecione uma forma de pagamento</option>";

    for (var i = 0; i < dados['financeiro\\taxa'].length; i++) {
        htmlTaxa += "<option value='" + dados['financeiro\\taxa'][i].id + "'>"
            + dados['financeiro\\taxa'][i].nome + "</option>";
    }

    for (var i = 0; i < dados['financeiro\\contabancaria'].length; i++) {
        htmlContaBancaria += "<option value='" + dados['financeiro\\contabancaria'][i].id + "'>"
            + dados['financeiro\\contabancaria'][i].nome + "</option>";
    }

    for (var i = 0; i < dados['financeiro\\formapagamento'].length; i++) {
        htmlFormaPagamento += "<option value='" + dados['financeiro\\formapagamento'][i].id + "'>"
            + dados['financeiro\\formapagamento'][i].nome + "</option>";
    }

    $("#taxa_id option").remove();
    $("#taxa_id").append(htmlTaxa);
    $("#conta_bancaria_id option").remove();
    $("#conta_bancaria_id").append(htmlContaBancaria);
    $("#forma_pagamento_id option").remove();
    $("#forma_pagamento_id").append(htmlFormaPagamento);

    // Carregando os campos do formulário referentes a taxa
    var idTaxa = $('#taxa_id').find('option:selected').val();
    getInfoTaxa(idTaxa, preencheCamposTaxa);

    $("#modal-create-debito").modal({show : true});
}

$('#btnSalvarDebito').click(function() {
    var taxa_id = $("#taxa_id option:selected").val();
    var data_vencimento = $("#data_vencimento").val();
    var valor_taxa = $("#valor_taxa").val();
    var valor_debito = $("#valor_debito").val();
    var mes_referencia = $("#mes_referencia").val();
    var ano_referencia = $("#ano_referencia").val();
    var conta_bancaria_id = $('#conta_bancaria_id option:selected').val();
    var forma_pagamento_id = $('#forma_pagamento_id option:selected').val();
    var gerar_carne = $('#gerar_carne option:selected').val();
    var quantidade = $('#quantidade').val();
    var pago = $('#pago option:selected').val();

    var dados = {
        'taxa_id' : taxa_id,
        'data_vencimento' : data_vencimento,
        'valor_taxa': valor_taxa,
        'valor_debito': valor_debito,
        'mes_referencia' : mes_referencia,
        'ano_referencia' : ano_referencia,
        'conta_bancaria_id' : conta_bancaria_id,
        'forma_pagamento_id': forma_pagamento_id,
        'gerar_carne' : gerar_carne,
        'quantidade' : quantidade,
        'pago': pago
    };

    var resultValidate = validaCampos(dados);
    if (!resultValidate) {
        return false;
    }

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/tecnico/aluno/financeiro/storeDebito/' + idAluno,
        data: dados,
        datatype: 'json',
        beforeSend: function() {
            $(".carregamento").show();
        },
        complete: function() {
            $(".carregamento").hide();
        }
    }).done(function (retorno) {
        if(retorno.success) {
            tableDebitos.ajax.reload();
            tableCarnes.ajax.reload();
            $('#modal-create-debito').modal('toggle');
            swal("Débito cadastrado com sucesso", "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

/**
 * Evento para ser disparado quando mudar de taxa
 */
$(document).on('change', '#taxa_id', function () {
    var idTaxa = $('#taxa_id').find('option:selected').val();
    getInfoTaxa(idTaxa, preencheCamposTaxa);
});