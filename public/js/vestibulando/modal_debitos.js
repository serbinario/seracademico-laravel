// variáveis de tabela de débitos
var tableDebitosAbertos;
var tableDebitosPagos;

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

// Função para executar a tabela de notas
function runFinanceiro(idVestibulando) {
    if(tableDebitosAbertos && tableDebitosPagos) {
        tableDebitosAbertos.ajax.url("/index.php/seracademico/vestibulando/financeiro/gridDebitosAbertos/" + idVestibulando).load();
        tableDebitosPagos.ajax.url("/index.php/seracademico/vestibulando/financeiro/gridDebitosPagos/" + idVestibulando).load();
    } else {
        loadTableDebitosAbertos(idVestibulando);
        loadTableDebitosPagos(idVestibulando);
    }

    // Abrindo o modal
    $('#modal-debitos').modal({ show:true });
}