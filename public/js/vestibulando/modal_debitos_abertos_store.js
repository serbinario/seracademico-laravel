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
            'Taxa'
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
        if(retorno['taxa'].length > 0) {
            builderHtmlFieldsDebitos(retorno);
        } else {
            // Retorno caso não matéria disponível
            swal("Desculpe não existe taxa disponível", "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDebitos (dados) {
    // limpando os campos
    $('#vencimento').val("");
    $('#valor_debito').val("");
    $('#mes_referencia').val("");
    $('#ano_referencia').val("");
    $('#observacao').val("");

    // Variáveis que armazenaram o html
    var htmlTaxa = "";

    // Percorrendo o array de disciplinacurriculo
    for(var i = 0; i < dados['taxa'].length; i++) {
        // Criando as options
        htmlTaxa += "<option value='" + dados['taxa'][i].id + "'>" + dados['taxa'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de período
    $("#taxa_id option").remove();
    $("#taxa_id").append(htmlTaxa);

    // Abrindo o modal de inserir disciplina
    $("#modal-debitos-abertos-store").modal({show : true});
};

// Evento para salvar tabela de preços
$('#btnDebitosAbertosSalvar').click(function() {
    // Recuperando os valores
    var taxa_id        = $("#taxa_id").val();
    var valor_debito   = $("#valor_debito").val();
    var vencimento     = $('#vencimento').val();
    var mes_referencia = $('#mes_referencia').val();
    var ano_referencia = $('#ano_referencia').val();
    var observacao     = $('#observacao').val();

    // Dados ajax
    var dados = {
        'vestibulando_id' : idVestibulando,
        'taxa_id' : taxa_id,
        'valor_debito' : valor_debito,
        'vencimento' : vencimento,
        'mes_referencia': mes_referencia,
        'ano_referencia': ano_referencia,
        'observacao': observacao,
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