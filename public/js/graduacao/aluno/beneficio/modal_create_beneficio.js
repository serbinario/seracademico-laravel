$('#modal-create-beneficio').on('hidden.bs.modal', function () {
    // Removendo as linhas da grid
    if (TableTaxasOfBeneficio) {
        TableTaxasOfBeneficio.rows().remove().draw();
    }
});

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
            'Financeiro\\Taxa',
            'Financeiro\\Incidencia',
            'Financeiro\\TipoValor'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        data: dados,
        url: '/index.php/seracademico/financeiro/beneficio/getLoadFields',
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
    $('#incidencia_id option').attr('selected', false);
    $('#tipo_id option').attr('selected', false);
    $("#taxa_id_beneficios").select2("val", "");


    // Variáveis que armazenaram o html
    var htmlTipoBeneficio = "<option value=''>Selecione um Tipo de Benefício</option>";
    //var htmlTaxa = "<option value=''>Selecione uma taxa</option>";
    var htmlIncidencia = "<option value=''>Selecione uma incidência</option>";
    var htmlTipoValor = "<option value=''>Selecione uma tipo</option>";

    // Percorrendo o array de taxaas
    //for (var i = 0; i < dados['financeiro\\taxa'].length; i++) {
    //    htmlTaxa += "<option value='" + dados['financeiro\\taxa'][i].id + "'>" + dados['financeiro\\taxa'][i].nome + "</option>";
    //}

    // Percorrendo o array de taxaas
    for (var i = 0; i < dados['financeiro\\tipobeneficio'].length; i++) {
        htmlTipoBeneficio += "<option value='" + dados['financeiro\\tipobeneficio'][i].id + "'>" + dados['financeiro\\tipobeneficio'][i].nome + "</option>";
    }

    // Percorrendo o array de incidencias
    for (var i = 0; i < dados['financeiro\\incidencia'].length; i++) {
        htmlIncidencia += "<option value='" + dados['financeiro\\incidencia'][i].id + "'>" + dados['financeiro\\incidencia'][i].nome + "</option>";
    }

    // Percorrendo o array de tipos valores
    for (var i = 0; i < dados['financeiro\\tipovalor'].length; i++) {
        htmlTipoValor += "<option value='" + dados['financeiro\\tipovalor'][i].id + "'>" + dados['financeiro\\tipovalor'][i].nome + "</option>";
    }

    // Carregado os selects
    //$("#taxa_id_beneficios option").remove();
    //$("#taxa_id_beneficios").append(htmlTaxa);
    $("#tipo_beneficio_id option").remove();
    $("#tipo_beneficio_id").append(htmlTipoBeneficio);
    $("#incidencia_id option").remove();
    $("#incidencia_id").append(htmlIncidencia);
    $("#tipo_id option").remove();
    $("#tipo_id").append(htmlTipoValor);

    // Carregando os valores padrão do formulário
    getInfoTipoBeneficio($('#tipo_beneficio_id').find('option:selected').val());
    
    // Abrindo o modal de inserir disciplina
    $("#modal-create-beneficio").modal({show : true});
}

// Evento para salvar histórico
$('#btnSaveBeneficio').click(function() {
    // Recuperando os campos dos formulário
    var tipo_beneficio_id = $("#tipo_beneficio_id option:selected").val();
    var valor  = $("#valor_beneficio").val();
    var data_inicio  = $("#data_inicio_beneficio").val();
    var data_fim  = $("#data_fim_beneficio").val();
    var incidencia_id  =$("#incidencia_id option:selected").val();
    var tipo_id  = $("#tipo_id option:selected").val();
    var taxas  = [];

    // Carregando as taxas
    $.each(TableTaxasOfBeneficio.rows().data(),function (index, val) {
        taxas[index] = val[0];
    });

    // Dados para cadastro
    var dados = {
        'aluno_id' : idAluno,
        'taxas' : taxas,
        'tipo_beneficio_id' : tipo_beneficio_id,
        'valor': valor,
        'data_inicio': data_inicio,
        'data_fim' : data_fim,
        'incidencia_id' : incidencia_id,
        'tipo_id' : tipo_id
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/beneficio/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableBeneficios.ajax.reload();

            // Removendo as linhas da grid
            if (TableTaxasOfBeneficio) {
                TableTaxasOfBeneficio.rows().remove().draw();
            }

            $('#modal-create-beneficio').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            // Mensagem de erro
            var msg = "";

            // Verificando o tipo de mensagem
            if(retorno.validator) {console.log(retorno.validator);
                // se for mensagem de validação
                $.each(retorno.msg, function (index, valor) {
                    msg += valor + "\n";
                });
            } else {
                msg = retorno.msg;
            }

            // Exibe a mensagem
            swal(msg, "Click no botão abaixo!", "error");
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
    if(!idTipoBeneficio) {
        return false;
    }
    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/tipoBeneficio/getTipoBeneficio/' + idTipoBeneficio,
        datatype: 'json'
    }).done(function (retorno) {
       if(retorno.success) {
           // Data Atual
           // var now = new Date();

           // Formatando os campos
           //$('#valor_desconto').val('0.00');
           $('#valor_beneficio').val(retorno.data.valor);
           $('#incidencia_id option[value='+ retorno.data.incidencia_id +']').attr('selected', true);
           $('#tipo_id option[value='+ retorno.data.tipo_id +']').attr('selected', true);
           $('#data_inicio_beneficio').val(retorno.data.data_inicio);
           $('#data_fim_beneficio').val(retorno.data.data_fim);
           //$('#mes_referencia').val(now.getMonth() + 1);
           //$('#ano_referencia').val(now.getFullYear());
           //$('#data_vencimento').val((retorno.data.dia_vencimento
           //        ? retorno.data.dia_vencimento : now.getDate()) + "/" + (now.getMonth() + 1) + "/" + now.getFullYear());
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
        url: '/index.php/seracademico/graduacao/historico/delete/' + idAlunoSemestre,
        datatype: 'json'
    }).done(function (retorno) {
        table.ajax.reload();
        tableHistorico.ajax.reload();
        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});

// Inicializando a grid de taxas do benefício
var TableTaxasOfBeneficio = $('#beneficios-taxas-grid').DataTable({
    iDisplayLength: 5,
    bLengthChange: false,
    bFilter: false,
    autoWidth: false,
    columnDefs: [
        {
            "targets": [0],
            "visible": false,
            "searchable": false
        }
    ]
});

// Evento para adicionar linhas para grid de taxas
$('#btnAddTaxa').on( 'click', function () {
    // Recuperando o id da taxa
    var taxaId = $('#taxa_id_beneficios').val();

    if (!taxaId) {
        swal('Você deve escolher uma taxa!', "Click no botão abaixo!", 'error');
        return false;
    }

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/financeiro/taxa/getTaxasIn/',
        data: {'taxas' : [taxaId]},
        datatype: 'json'
    }).done(function (retorno) {
        // Removendo a seleção do select
        //$('#taxa_id_beneficios option').attr('selected', false);
        $("#taxa_id_beneficios").select2("val", "");

        // Percorrendo o array de retorno
        $.each(retorno.data, function (index, value) {
            TableTaxasOfBeneficio.row.add(
                [
                    value.id,
                    value.codigo,
                    value.nome,
                    value.action
                ]
            ).draw( false );

            // escondendo o option
            //$('#taxa_id_beneficios option[value='+  value.id + ']').hide();
        });
    });
} );

// Removendo a linha da grid
$(document).on( 'click', '#btnDeleteTaxa', function () {
    // Recuperando o id od registro
   //var id = TableTaxasOfBeneficio.row($(this).parent().parent()).data()[0];

    // Exibindo a option do select
    // $('#taxa_id_beneficios option[value='+  id + ']').show();

    //Removendo a seleção
    $("#taxa_id_beneficios").select2("val", "");

    // Removendo a linha da grid
    TableTaxasOfBeneficio
        .row( $(this).parents('tr') )
        .remove()
        .draw();
} );