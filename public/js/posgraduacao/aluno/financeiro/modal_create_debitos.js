// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnModalCreateDebitos", function () {
    loadFieldsDebito();
});


// carregando todos os campos preenchidos
function loadFieldsDebito()
{
    var dados =  {
        'models' : [
            'Financeiro\\Taxa'
        ]
    };

    jQuery.ajax({
        type: 'GET',
        data: dados,
        url: '/index.php/seracademico/posgraduacao/aluno/financeiro/getLoadFields',
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

// Função a montar o html
function builderHtmlFieldsDebito (dados) {
    $('#taxa_id option').attr('selected', false);
    $('#conta_bancaria_id option').attr('selected', false);
    $('#pago option').attr('selected', false);
    $('#data_vencimento').val('');
    $('#valor_taxa').val('');
    $('#valor_debito').val('');
    $('#mes_referencia').val('');
    $('#ano_referencia').val('');

    var htmlTaxa = "";

    for (var i = 0; i < dados['financeiro\\taxa'].length; i++) {
        htmlTaxa += "<option value='" + dados['financeiro\\taxa'][i].id + "'>"
            + dados['financeiro\\taxa'][i].nome + "</option>";
    }

    $("#taxa_id option").remove();
    $("#taxa_id").append(htmlTaxa);

    // Carregando os campos do formulário referentes a taxa
    var idTaxa = $('#taxa_id').find('option:selected').val();
    getInfoTaxa(idTaxa, preencheCamposTaxa);

    $("#modal-create-debito").modal({show : true});
}

// Evento para salvar histórico
$('#btnSalvarDebito').click(function() {
    var taxa_id = $("#taxa_id option:selected").val();
    var data_vencimento = $("#data_vencimento").val();
    var valor_taxa = $("#valor_taxa").val();
    var valor_debito = $("#valor_debito").val();
    var mes_referencia = $("#mes_referencia").val();
    var ano_referencia = $("#ano_referencia").val();
    var conta_bancaria_id = $('#conta_bancaria_id option:selected').val();
    var pago = $('#pago option:selected').val();

    var dados = {
        'taxa_id' : taxa_id,
        'data_vencimento' : data_vencimento,
        'valor_taxa': valor_taxa,
        'valor_debito': valor_debito,
        'mes_referencia' : mes_referencia,
        'ano_referencia' : ano_referencia,
        'conta_bancaria_id' : conta_bancaria_id,
        'pago': pago
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/aluno/financeiro/storeDebito/' + idAluno,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDebitos.ajax.reload();
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