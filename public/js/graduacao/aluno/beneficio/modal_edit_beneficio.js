// Id do benefício e table
var idBeneficio, TableTaxasOfBeneficioEditar;

// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#btnEditBeneficio", function () {
    idBeneficio = tableBeneficios.row($(this).parent().parent().index()).data().id;
    loadFieldsBeneficioEditar();

    // Carregando a grid de debitos
    if(TableTaxasOfBeneficioEditar) {
        loadTableTaxasOfBeneficioEditar().ajax.url("/index.php/seracademico/financeiro/aluno/beneficio/gridTaxas/" + idBeneficio).load();
    } else {
        loadTableTaxasOfBeneficioEditar();
    }
});

// Função para carregamento da grid dtaxas
function loadTableTaxasOfBeneficioEditar() {
    // Inicializando a grid de taxas do benefício
    TableTaxasOfBeneficioEditar = $('#beneficios-taxas-grid-editar').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/financeiro/aluno/beneficio/gridTaxas/" + idBeneficio,
        columns: [
            {data: 'codigo', name: 'codigo'},
            {data: 'nome', name: 'nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return TableTaxasOfBeneficioEditar;
}


// carregando todos os campos preenchidos
function loadFieldsBeneficioEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Financeiro\\TipoBeneficio',
            //'Financeiro\\Taxa|notBeneficio,' + idBeneficio,
            'Financeiro\\Incidencia',
            'Financeiro\\TipoValor'
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
            builderHtmlFieldsBeneficioEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-edit-beneficio').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsBeneficioEditar (dados) {
    // Fazendo a requisição para recuperar os dados do curriculoDisciplina
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/financeiro/aluno/beneficio/edit/' + idBeneficio,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            //Limpando os campos
            $("#taxa_id_beneficios_editar").select2("val", "");

            // Variáveis que armazenaram o html
            var htmlTipoBeneficio = "";
            //var htmlTaxa = "<option value=''>Selecione uma taxa</option>";
            var htmlIncidencia = "<option value=''>Selecione uma incidência</option>";
            var htmlTipoValor = "<option value=''>Selecione uma tipo</option>";

            // Percorrendo o array de taxaas
            // for (var i = 0; i < dados['financeiro\\taxa'].length; i++) {
            //     htmlTaxa += "<option value='" + dados['financeiro\\taxa'][i].id + "'>" + dados['financeiro\\taxa'][i].nome + "</option>";
            // }

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
            //$("#taxa_id_beneficios_editar option").remove();
            // $("#taxa_id_beneficios_editar").append(htmlTaxa);
            $("#tipo_beneficio_id_editar option").remove();
            $("#tipo_beneficio_id_editar").append(htmlTipoBeneficio);
            $("#incidencia_id_editar option").remove();
            $("#incidencia_id_editar").append(htmlIncidencia);
            $("#tipo_id_editar option").remove();
            $("#tipo_id_editar").append(htmlTipoValor);


            // Setando os valores do model no formulário
            $('#tipo_beneficio_id_editar option[value=' + retorno.data.tipo_beneficio_id +']').attr('selected', true);
            $('#valor_beneficio_editar').val(retorno.data.valor);
            $('#data_inicio_beneficio_editar').val(retorno.data.data_inicio);
            $('#data_fim_beneficio_editar').val(retorno.data.data_fim);
            $('#tipo_id_editar option[value=' + retorno.data.tipo_id +']').attr('selected', true);
            $('#incidencia_id_editar option[value=' + retorno.data.incidencia_id +']').attr('selected', true);
            
            // Abrindo o modal de inserir disciplina
            $("#modal-edit-beneficio").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdateBeneficio').click(function() {
    // Recuperando os campos dos formulário
    var tipo_beneficio_id = $("#tipo_beneficio_id_editar option:selected").val();
    var valor  = $("#valor_beneficio_editar").val();
    var data_inicio  = $("#data_inicio_beneficio_editar").val();
    var data_fim  = $("#data_fim_beneficio_editar").val();
    var incidencia_id  =$("#incidencia_id_editar option:selected").val();
    var tipo_id  = $("#tipo_id_editar option:selected").val();

    // Dados para cadastro
    var dados = {
        'aluno_id' : idAluno,
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
        url: '/index.php/seracademico/financeiro/aluno/beneficio/update/' + idBeneficio,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableBeneficios.ajax.reload();
            $('#modal-edit-beneficio').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

/**
 * Evento para ser disparado quando mudar de taxa
 */
$(document).on('change', '#tipo_beneficio_id_Editar', function () {
    getInfoTipoBeneficioEditar($(this).find('option:selected').val());
});

/**
 * Função responsável por recuperar o tipo de benefício
 * preencher os campos de cadastro.
 *
 * @param idTipoBeneficio
 */
function getInfoTipoBeneficioEditar(idTipoBeneficio)
{
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
            $('#valor_beneficio_editar').val(retorno.data.valor);
            //$('#valor_debito').val(retorno.data.valor);
            //$('#mes_referencia').val(now.getMonth() + 1);
            //$('#ano_referencia').val(now.getFullYear());
            //$('#data_vencimento').val((retorno.data.dia_vencimento
            //        ? retorno.data.dia_vencimento : now.getDate()) + "/" + (now.getMonth() + 1) + "/" + now.getFullYear());
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para adicionar linhas para grid de taxas
$('#btnAddTaxaEditar').on( 'click', function () {
    // Recuperando o id da taxa
    var taxaId = $('#taxa_id_beneficios_editar').find('option:selected').val();

    if (!taxaId) {
        swal('Você deve escolher uma taxa!', "Click no botão abaixo!", 'error');
        return false;
    }

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/aluno/beneficio/attachTaxa/' + idBeneficio,
        data: {'taxas' : [taxaId]},
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Limpando a seleção
            $("#taxa_id_beneficios_editar").select2("val", "");

            TableTaxasOfBeneficioEditar.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", 'success');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", 'error');
        }
    });
} );

// Removendo a linha da grid
$(document).on( 'click', '#btnDestroyBeneficioEditar', function () {
    // Recuperando o id od registro
    var taxaId = TableTaxasOfBeneficioEditar.row($(this).parent().parent()).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/aluno/beneficio/detachTaxa/' + idBeneficio,
        data: {'taxas' : [taxaId]},
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Limpando a seleção
            $("#taxa_id_beneficios_editar").select2("val", "");
            
            TableTaxasOfBeneficioEditar.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", 'success');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", 'error');
        }
    });
});

// Função exclusiva para carregar o select de taxas
function loadFeldsTaxas() {
    // Definindo os models
    var dados =  {
        'models' : [
            'Financeiro\\Taxa|notBeneficio,' + idBeneficio
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
            var htmlTaxa = "<option value=''>Selecione uma taxa</option>";

            // Percorrendo o array de taxaas
            for (var i = 0; i < retorno['financeiro\\taxa'].length; i++) {
                htmlTaxa += "<option value='" + retorno['financeiro\\taxa'][i].id + "'>" + retorno['financeiro\\taxa'][i].nome + "</option>";
            }

            // Carregado os selects
            $("#taxa_id_beneficios_editar option").remove();
            $("#taxa_id_beneficios_editar").append(htmlTaxa);
        }
    });
}