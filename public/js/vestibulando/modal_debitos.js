// variáveis de tabela de débitos
var tableDebitosAbertos;
var tableDebitosPagos;
var tableBoletos;

// Função para carregamento da tabela de debitos pagos
function loadTableDebitosAbertos(idVestibulando) {
    tableDebitosAbertos = $('#debitos-abertos-grid').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        retrieve: true,
        ajax: "/index.php/seracademico/vestibulando/financeiro/gridDebitosAbertos/" + idVestibulando,
        columns: [
            {data: 'codigo', name: 'fin_taxas.codigo', orderable: false},
            {data: 'nome', name: 'fin_taxas.nome', orderable: false},
            {data: 'vencimento', name: 'fac_vestibulandos_finaceiros.vencimento', orderable: false},
            {data: 'valor', name: 'fin_taxas.valor', orderable: false},
           // {data: 'valor', name: 'fin_taxas.valor', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
}

// Função para carregamento da tabela de debitos pagos
function loadTableDebitosPagos(idVestibulando) {
    tableDebitosPagos = $('#debitos-pagos-grid').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        retrieve: true,
        ajax: "/index.php/seracademico/vestibulando/financeiro/gridDebitosPagos/" + idVestibulando,
        columns: [
            {data: 'codigo', name: 'fin_taxas.codigo', orderable: false},
            {data: 'nome', name: 'fin_taxas.nome', orderable: false},
            {data: 'data_pagamento', name: 'fac_vestibulandos_finaceiros.vencimento', orderable: false},
            {data: 'valor_desconto', name: 'fac_vestibulandos_finaceiros.valor_desconto', orderable: false},
            {data: 'valor_pago', name: 'fac_vestibulandos_finaceiros.valor_pago', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
           // {data: 'valor', name: 'fin_taxas.valor', orderable: false}
           // {data: 'mes_referencia', name: 'fac_vestibulandos_finaceiros.mes_referencia', orderable: false},
           // {data: 'ano_referencia', name: 'fac_vestibulandos_finaceiros.ano_referencia', orderable: false}
        ]
    });
}

// Função para carregar a grid
function loadTableBoletos (idVestibulando) {
    tableBoletos = $('#grid-boletos').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/vestibulando/financeiro/gridBoletos/" + idVestibulando,
        columns: [
            {data: 'nosso_numero', name: 'fin_boletos_vestibulandos.nosso_numero'},
            {data: 'vencimento', name: 'fin_boletos_vestibulandos.vencimento'},
            {data: 'valor_debito', name: 'fac_vestibulandos_financeiros.valor_debito'},
            {data: 'data', name: 'fin_boletos_vestibulandos.data'},
            {data: 'numero', name: 'fin_boletos_vestibulandos.numero'}
            //{data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableBoletos;
}

// Função para executar a tabela de notas
function runFinanceiro(idVestibulando) {
    if(tableDebitosAbertos && tableDebitosPagos && tableBoletos) {
        tableDebitosAbertos.ajax.url("/index.php/seracademico/vestibulando/financeiro/gridDebitosAbertos/" + idVestibulando).load();
        tableDebitosPagos.ajax.url("/index.php/seracademico/vestibulando/financeiro/gridDebitosPagos/" + idVestibulando).load();
        tableBoletos.ajax.url("/index.php/seracademico/vestibulando/financeiro/gridBoletos/" + idVestibulando).load();
    } else {
        loadTableDebitosAbertos(idVestibulando);
        loadTableDebitosPagos(idVestibulando);
        loadTableBoletos(idVestibulando);
    }

    // Abrindo o modal
    $('#modal-debitos').modal({ show:true });
}


// Evento para gerar boleto
$(document).on('click', '#btnGerarBoleto', function () {
    // Recuperando o débito
    var idDebito = tableDebitosAbertos.row($(this).parent().parent().parent().parent().parent().index()).data().id;

    // Dados para requisição
    var dados = {
        'idDebito' : idDebito
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/vestibulando/financeiro/storeBoleto',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno.success) {
            tableBoletos.ajax.reload();
            window.open('/index.php/seracademico/vestibulando/financeiro/gerarBoleto/' + retorno.data.id,  '_blank');
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});