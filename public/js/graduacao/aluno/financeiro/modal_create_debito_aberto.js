// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnCreateDebitoAberto", function () {
    loadFieldsDebitosAbertos();
});

// carregando todos os campos preenchidos
function loadFieldsDebitosAbertos()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Financeiro\\Taxa'
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
            builderHtmlFieldsDebitosAbertos(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-historico').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDebitosAbertos (dados) {
    //Limpando os campos
    $('#taxa_id option').attr('selected', false);
    $('#data_vencimento').val('');
    $('#valor_taxa').val('');
    $('#valor_debito').val('');
    $('#mes_referencia').val('');
    $('#ano_referencia').val('');


    // Variáveis que armazenaram o html
    var htmlTaxa     = "";

    // Percorrendo o array de taxaas
    for (var i = 0; i < dados['financeiro\\taxa'].length; i++) {
        htmlTaxa += "<option value='" + dados['financeiro\\taxa'][i].id + "'>" + dados['financeiro\\taxa'][i].nome + "</option>";
    }

    // Carregado os selects
    $("#taxa_id option").remove();
    $("#taxa_id").append(htmlTaxa);

    // Carregando os campos do formulário referentes a taxa
    getInfoTaxa($('#taxa_id').find('option:selected').val());

    // Abrindo o modal de inserir disciplina
    $("#modal-create-debito-aberto").modal({show : true});
}

// Evento para salvar histórico
$('#btnSaveDebitoAberto').click(function() {
    var taxa_id         = $("#taxa_id option:selected").val();
    var data_vencimento = $("#data_vencimento").val();
    var valor_taxa      = $("#valor_taxa").val();
    var valor_debito    = $("#valor_debito").val();
    var mes_referencia  = $("#mes_referencia").val();
    var ano_referencia  = $("#ano_referencia").val();
    var valor_desconto  = $("#valor_desconto").val();

    var dados = {
        'aluno_id' : idAluno,
        'taxa_id' : taxa_id,
        'data_vencimento' : data_vencimento,
        'valor_taxa': valor_taxa,
        'valor_debito': valor_debito,
        'mes_referencia' : mes_referencia,
        'ano_referencia' : ano_referencia,
        'valor_desconto' : valor_desconto
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/aluno/storeDebitoAberto',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDebitosAbertos.ajax.reload();

            $('#modal-create-debito-aberto').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

/**
 * Evento para ser disparado quando mudar de taxa
 */
$(document).on('change', '#taxa_id', function () {
    getInfoTaxa($(this).find('option:selected').val());
});

/**
 * Função responsável por recuperar a taxa e
 * preencher os campos de cadastro.
 *
 * @param idTaxa
 */
function getInfoTaxa(idTaxa)
{
    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/taxa/getTaxa/' + idTaxa,
        datatype: 'json'
    }).done(function (retorno) {
       if(retorno.success) {
           // Data Atual
           var now = new Date();

           // Formatando os campos
           $('#valor_desconto').val('0.00');
           $('#valor_taxa').val(retorno.data.valor);
           $('#valor_debito').val(retorno.data.valor);
           $('#mes_referencia').val(now.getMonth() + 1);
           $('#ano_referencia').val(now.getFullYear());
           $('#data_vencimento').val((retorno.data.dia_vencimento
                   ? retorno.data.dia_vencimento : now.getDate()) + "/" + (now.getMonth() + 1) + "/" + now.getFullYear());
       } else {
           swal(retorno.msg, "Click no botão abaixo!", "error");
       }        
    });
}


// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDeleteHistorico', function () {
    // recuperando o id do aluno_semestre
    var idAlunoSemestre = tableHistorico.row($(this).parent().parent().index()).data().idAlunoSemestre;

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/historico/delete/' + idAlunoSemestre,
        datatype: 'json'
    }).done(function (retorno) {
        table.ajax.reload();
        tableHistorico.ajax.reload();
        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});