// Função para carregar a grid
var tableDebitos;
function loadTableDebitos (idAluno) {
    tableDebitos = $('#grid-debitos').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        //bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/financeiro/gridDebitos/" + idAluno,
        columns: [
            {data: 'nomeTaxa', name: 'fin_taxas.nome'},
            {data: 'data_vencimento', name: 'fin_debitos.data_vencimento'},
            {data: 'valor_debito', name: 'fin_debitos.valor_debito'},
            {data: 'situacaoBoleto', name: 'fin_status_gnet.nome'},
            {data: 'gnet_carnet_id', name: 'fin_carnes.gnet_carnet_id'},
            {data: 'pago', name: 'fin_debitos.pago'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableDebitos;
}

var tableCarnes;
function loadTableCarnes (idAluno) {
    tableCarnes = $('#grid-carnes').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/financeiro/gridCarnes/" + idAluno,
        columns: [
            {data: 'gnet_carnet_id', name: 'fin_carnes.gnet_carnet_id'},
            {data: 'data_criacao', name: 'fin_carnes.created_at'},
            {data: 'qtd_parcelas', name: 'qtd_parcelas', orderable: false, searchable: false},
            {data: 'nomeTaxa', name: 'nomeTaxa'},
            {data: 'valorTaxa', name: 'fin_taxas.valor'},
            {data: 'link', name: 'link', orderable: false, searchable: false}
        ]
    });

    return tableCarnes;
}

// Função para executar a grid
function runFinanceiro(idAluno) {
    if(tableDebitos) {
        loadTableDebitos(idAluno)
            .ajax
            .url("/index.php/seracademico/graduacao/aluno/financeiro/gridDebitos/" + idAluno)
            .load();
    } else {
        loadTableDebitos(idAluno);
    }

    if(tableCarnes) {
        loadTableCarnes(idAluno)
            .ajax
            .url("/index.php/seracademico/graduacao/aluno/financeiro/gridCarnes/" + idAluno)
            .load();
    } else {
        loadTableCarnes(idAluno);
    }

    // carregando a modal
    $("#modal-debitos").modal({show:true});
}