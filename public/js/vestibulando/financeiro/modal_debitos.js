var tableDebitosAbertos;
var tableDebitosPagos;

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
            {data: 'nomeTaxa', name: 'fin_taxas.nome', orderable: false},
            {data: 'data_vencimento', name: 'fin_debitos.data_vencimento', orderable: false},
            {data: 'valor_debito', name: 'fin_debitos.valor_debito', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
}

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
            {data: 'nomeTaxa', name: 'fin_taxas.nome', orderable: false},
            {data: 'data_vencimento', name: 'fin_debitos.data_vencimento', orderable: false},
            {data: 'valor_debito', name: 'fin_debitos.valor_debito', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
}

function runFinanceiro(idVestibulando) {
    if(tableDebitosAbertos && tableDebitosPagos) {
        tableDebitosAbertos.ajax.url("/index.php/seracademico/vestibulando/financeiro/gridDebitosAbertos/" + idVestibulando).load();
        tableDebitosPagos.ajax.url("/index.php/seracademico/vestibulando/financeiro/gridDebitosPagos/" + idVestibulando).load();
    } else {
        loadTableDebitosAbertos(idVestibulando);
        loadTableDebitosPagos(idVestibulando);
    }

    $('#modal-debitos').modal({ show:true });
}