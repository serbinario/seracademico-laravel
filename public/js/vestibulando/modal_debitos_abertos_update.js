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
            // Setando os valores do model no formulário
            $('#tipo_taxa_id_editar').html('<option value="' + retorno.data.tipoTaxaId + '">'  + retorno.data.tipoTaxaNome + '</option>');
            $('#taxa_id_editar').html('<option value="' + retorno.data.taxaId + '">'  + retorno.data.taxaNome + '</option>');
            $('#valor_taxa_vestibulando_editar').val(retorno.data.taxaValor);
            $('#vencimento_editar').val(retorno.data.vencimento);
            $('#valor_debito_editar').val(retorno.data.valor_debito);
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
    // Recuperando os valores
    var taxa_id        = $("#taxa_id_editar").val();
    var valor_debito   = $("#valor_debito_editar").val();
    var valor_desconto = $("#valor_desconto_editar").val();
    var vencimento     = $('#vencimento_editar').val();
    var mes_referencia = $('#mes_referencia_editar').val();
    var ano_referencia = $('#ano_referencia_editar').val();
    var observacao     = $('#observacao_editar').val();
    var pago           = $('#pago:checked').val();

    // Dados ajax
    var dados = {
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
    // variáveis de uso
    var valorDebito, valorDeconto, valorFinal, valorProvFinal, valorTaxa;

    // Recebendo e tratando as entradas
    valorDeconto = Number($(this).val());
    valorDebito  = Number($('#valor_debito_editar').val());
    valorTaxa    = Number($('#valor_taxa_vestibulando_editar').val());

    // Regra de verificação
    if(valorDebito == 0) {
        valorDebito = valorTaxa;
    }

    // Verificando se é um número
    if(valorDebito == "" || !valorTaxa) {
        return false;
    }

    // Regra para o valor do desconto, caso seja 0 ou vazio
    if(!valorDeconto) {
        $('#valor_debito_editar').val(valorTaxa);
        return false;
    }

    // Validação dos valores
    if(valorDeconto > valorTaxa) {
        swal('Valor de desconto tem que ser menor ou igual ao valor do débito');
        return false;
    }

    // Calculando o valor provisório final
    valorProvFinal = valorDebito - valorDeconto;

    // Regra de cálculo
    if((valorProvFinal + valorDeconto) != valorTaxa) {
        valorFinal = valorProvFinal + (valorTaxa - (valorProvFinal + valorDeconto));
    } else {
        valorFinal = valorProvFinal;
    }

    // Calculando o valor final
    $('#valor_debito_editar').val(valorFinal); // get the current value of the input field.
});