$(document).on("click", "#btnEditarDebito", function () {
    idDebito = tableDebitos.row($(this).parents('tr')).data().id;
    loadFieldsDebitoEditar();
});

function loadFieldsDebitoEditar()
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
        url: '/index.php/seracademico/emais/aluno/financeiro/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno) {
            builderHtmlFieldsDebitoEditar(retorno);
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-edit-debitos').modal('toggle');
        }
    });
};

function builderHtmlFieldsDebitoEditar (dados) {
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/emais/aluno/financeiro/getDebito/' + idDebito,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
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

            $("#taxa_id_editar option").remove();
            $("#taxa_id_editar").append(htmlTaxa);
            $("#conta_bancaria_id_editar option").remove();
            $("#conta_bancaria_id_editar").append(htmlContaBancaria);
            $("#forma_pagamento_id_editar option").remove();
            $("#forma_pagamento_id_editar").append(htmlFormaPagamento);

            // Setando os valores do model no formulário
            $('#taxa_id_editar option[value=' + retorno.data.taxa_id  +']').attr('selected', true);
            $('#pago_editar option[value=' + retorno.data.pago  +']').attr('selected', true);
            $('#conta_bancaria_id_editar option[value=' + retorno.data.conta_bancaria_id  +']').attr('selected', true);
            var forma_pagamento_id = retorno.data.forma_pagamento ?  retorno.data.forma_pagamento.id : null;
            $('#forma_pagamento_id_editar option[value=' + forma_pagamento_id  +']').attr('selected', true);
            $('#data_vencimento_editar').val(retorno.data.data_vencimento);
            $('#valor_debito_editar').val(retorno.data.valor_debito);
            $('#valor_taxa_editar').val(retorno.data.taxa.valor);
            $('#mes_referencia_editar').val(retorno.data.mes_referencia);
            $('#ano_referencia_editar').val(retorno.data.ano_referencia);

            // Abrindo o modal de inserir disciplina
            $("#modal-edit-debito").modal({show : true});
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

$('#btnUpdateDebito').click(function() {
    var taxa_id = $("#taxa_id_editar option:selected").val();
    var data_vencimento = $("#data_vencimento_editar").val();
    var valor_taxa = $("#valor_taxa_editar").val();
    var valor_debito = $("#valor_debito_editar").val();
    var mes_referencia = $("#mes_referencia_editar").val();
    var ano_referencia = $("#ano_referencia_editar").val();
    var conta_bancaria_id = $('#conta_bancaria_id_editar option:selected').val();
    var forma_pagamento_id = $('#forma_pagamento_id_editar option:selected').val();
    var pago = $('#pago_editar option:selected').val();

    var dados = {
        'taxa_id' : taxa_id,
        'data_vencimento' : data_vencimento,
        'valor_taxa': valor_taxa,
        'valor_debito': valor_debito,
        'mes_referencia' : mes_referencia,
        'ano_referencia' : ano_referencia,
        'conta_bancaria_id' : conta_bancaria_id,
        'forma_pagamento_id' : forma_pagamento_id,
        'pago': pago
    };

    var resultValidate = validaCampos(dados);
    if (!resultValidate) {
        return false;
    }

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/emais/aluno/financeiro/updateDebito/' + idDebito,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDebitos.ajax.reload();
            $('#modal-edit-debito').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

function preencheCamposTaxaEditar (retorno) {
    if (retorno.success) {
        var now = new Date();
        var dataVencimento = (retorno.data.dia_vencimento
                ? retorno.data.dia_vencimento
                : now.getDate()) + "/" + (now.getMonth() + 1) + "/" + now.getFullYear();

        $('#valor_taxa_editar').val(retorno.data.valor);
        $('#valor_debito_editar').val(retorno.data.valor);
        $('#data_vencimento_editar').val(dataVencimento);
    } else {
        swal(
            'O preenchimento automático dos campos pela taxa não pode ser concluído',
            'Click no botão abaixo!',
            'error'
        );
    }
}

/**
 * Evento para ser disparado quando mudar de taxa
 */
$(document).on('change', '#taxa_id_editar', function () {
    var idTaxa = $('#taxa_id_editar').find('option:selected').val();
    getInfoTaxa(idTaxa, preencheCamposTaxaEditar);
});