// variáveis de tabela de débitos
var tableDebitosAbertos;
var tableDebitosPagos;

// Função para carregamento da tabela de notas
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
            {data: 'codigo', name: 'fin_taxas.codigo'},
            {data: 'nome', name: 'fin_taxas.nome'},
            {data: 'vencimento', name: 'fac_vestibulandos_finaceiros.vencimento'},
            {data: 'valor', name: 'fin_taxas.valor'},
            {data: 'mes_referencia', name: 'fac_vestibulandos_finaceiros.mes_referencia'},
            {data: 'ano_referencia', name: 'fac_vestibulandos_finaceiros.ano_referencia'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
}

// Função para carregamento da tabela de debitos abertos
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
            {data: 'codigo', name: 'fin_taxas.codigo'},
            {data: 'nome', name: 'fin_taxas.nome'},
            {data: 'vencimento', name: 'fac_vestibulandos_finaceiros.vencimento'},
            {data: 'valor', name: 'fin_taxas.valor'},
            {data: 'mes_referencia', name: 'fac_vestibulandos_finaceiros.mes_referencia'},
            {data: 'ano_referencia', name: 'fac_vestibulandos_finaceiros.ano_referencia'}
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