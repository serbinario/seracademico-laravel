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
            $('#taxa_id_editar').html('<option value="' + retorno.data.taxaId + '">'  + retorno.data.taxaNome + '</option>'); 
            $('#vencimento_editar').val(retorno.data.vencimento);
            $('#valor_debito_editar').val(retorno.data.valor_debito);
            $('#mes_referencia_editar').val(retorno.data.mes_referencia);
            $('#ano_referencia_editar').val(retorno.data.ano_referencia);
            $('#observacao_editar').val(retorno.data.observacao);
            console.log(retorno.data.pago);
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
    var vencimento     = $('#vencimento_editar').val();
    var mes_referencia = $('#mes_referencia_editar').val();
    var ano_referencia = $('#ano_referencia_editar').val();
    var observacao     = $('#observacao_editar').val();
    var pago           = $('#pago').val();

    // Dados ajax
    var dados = {
        'vestibulando_id' : idVestibulando,
        'taxa_id' : taxa_id,
        'valor_debito' : valor_debito,
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
            
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});