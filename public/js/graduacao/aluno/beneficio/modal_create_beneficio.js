// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnCreateBeneficio", function () {
    loadFieldsBeneficio();
});

// carregando todos os campos preenchidos
function loadFieldsBeneficio()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Financeiro\\TipoBeneficio',
            'Financeiro\\Taxa'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        data: dados,
        url: '/index.php/seracademico/financeiro/aluno/beneficio/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsBeneficio(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-beneficio').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsBeneficio (dados) {
    //Limpando os campos
    $('#tipo_beneficio_id option').attr('selected', false);
    $('#data_inicio_beneficio').val('');
    $('#data_fim_beneficio').val('');
    $('#valor_beneficio').val('');
    $('#taxas_beneficio option').attr('selected', false);


    // Variáveis que armazenaram o html
    var htmlTipoBeneficio = "";
    var htmlTaxa = "";

    // Percorrendo o array de taxaas
    for (var i = 0; i < dados['financeiro\\taxa'].length; i++) {
        htmlTaxa += "<option value='" + dados['financeiro\\taxa'][i].id + "'>" + dados['financeiro\\taxa'][i].nome + "</option>";
    }

    // Percorrendo o array de taxaas
    for (var i = 0; i < dados['financeiro\\tipobeneficio'].length; i++) {
        htmlTipoBeneficio += "<option value='" + dados['financeiro\\tipobeneficio'][i].id + "'>" + dados['financeiro\\tipobeneficio'][i].nome + "</option>";
    }

    // Carregado os selects
    $("#taxas_beneficio option").remove();
    $("#taxas_beneficio").append(htmlTaxa);
    $("#tipo_beneficio_id option").remove();
    $("#tipo_beneficio_id").append(htmlTipoBeneficio);
    console.log('dsadsa');
    // Abrindo o modal de inserir disciplina
    $("#modal-create-beneficio").modal({show : true});
}

// Evento para salvar histórico
$('#btnSaveBeneficio').click(function() {
    var taxas             = $("#taxas_beneficio").val();
    var tipo_beneficio_id = $("#tipo_beneficio_id option:selected").val();
    var valor             = $("#valor_beneficio").val();
    var data_inicio       = $("#data_inicio_beneficio").val();
    var data_fim          = $("#data_fim_beneficio").val();


    var dados = {
        'aluno_id' : idAluno,
        'taxas' : taxas,
        'tipo_beneficio_id' : tipo_beneficio_id,
        'valor': valor,
        'data_inicio': data_inicio,
        'data_fim' : data_fim
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/aluno/beneficio/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableBeneficios.ajax.reload();

            $('#modal-create-beneficio').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

/**
 * Evento para ser disparado quando mudar de taxa
 */
$(document).on('change', '#tipo_beneficio_id', function () {
    getInfoTipoBeneficio($(this).find('option:selected').val());
});

/**
 * Função responsável por recuperar o tipo de benefício
 * preencher os campos de cadastro.
 *
 * @param idTipoBeneficio
 */
function getInfoTipoBeneficio(idTipoBeneficio)
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