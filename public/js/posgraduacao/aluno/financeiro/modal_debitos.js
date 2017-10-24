// Função para carregar a grid
var tableDebitos;
function loadTableDebitos (idAluno) {
    tableDebitos = $('#grid-debitos').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/financeiro/gridDebitos/" + idAluno,
        columns: [
            /*{
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },*/
            {data: 'nomeTaxa', name: 'nomeTaxa'},
            {data: 'data_vencimento', name: 'data_vencimento'},
            {data: 'valor_debito', name: 'valor_debito'},
            {data: 'situacaoBoleto', name: 'situacaoBoleto'},
            {data: 'pago', name: 'pago'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // array de detalhes da grid
    var detailRows = [];

    // evento para criação dos detalhes da grid
    $('#grid-acursar').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableACursar.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( formatAcursar( row.data() ) ).show();

            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );

    // On each draw, loop over the `detailRows` array and show any child rows
    tableDebitos.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

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
        ajax: "/index.php/seracademico/posgraduacao/aluno/financeiro/gridCarnes/" + idAluno,
        columns: [
            {data: 'gnet_carnet_id', name: 'fin_carnes.gnet_carnet_id'},
            {data: 'data_criacao', name: 'fin_carnes.created_at'},
            {data: 'qtd_parcelas', name: 'qtd_parcelas', orderable: false, searchable: false},
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
            .url("/index.php/seracademico/posgraduacao/aluno/financeiro/gridDebitos/" + idAluno)
            .load();
    } else {
        loadTableDebitos(idAluno);
    }

    if(tableCarnes) {
        loadTableCarnes(idAluno)
            .ajax
            .url("/index.php/seracademico/posgraduacao/aluno/financeiro/gridCarnes/" + idAluno)
            .load();
    } else {
        loadTableCarnes(idAluno);
    }

    // carregando a modal
    $("#modal-debitos").modal({show:true});
}