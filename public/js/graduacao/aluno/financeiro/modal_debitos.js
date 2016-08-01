// Função para carregar a grid
var tableDebitosAbertos;
function loadTableDebitosAbertos (idAluno) {
    tableDebitosAbertos = $('#grid-debitos-abertos').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/financeiro/aluno/gridDebitosAbertos/" + idAluno,
        columns: [
            // {
            //     "className":      'details-control',
            //     "orderable":      false,
            //     "data":           null,
            //     "defaultContent": ''
            // },
            {data: 'codigo', name: 'fin_taxas.codigo'},
            {data: 'nome', name: 'fin_taxas.nome'},
            {data: 'valor', name: 'fin_taxas.valor'},
            {data: 'data_vencimento', name: 'fin_debitos.data_vencimento'},
            {data: 'valor_multa', name: 'fin_taxas.valor_multa'},
            {data: 'valor_juros', name: 'fin_taxas.valor_juros'},
            {data: 'valor_debito', name: 'fin_debitos.valor_debito'},
            {data: 'mes_referencia', name: 'fin_debitos.mes_referencia'},
            {data: 'ano_referencia', name: 'fin_debitos.ano_referencia'},
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
    tableDebitosAbertos.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

    return tableDebitosAbertos;
}

// Função para carregar a grid
var tableDebitosFechados;
function loadTableDebitosFechados (idAluno) {
    tableDebitosFechados = $('#grid-debitos-fechados').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridCursadas/" + idAluno,
        columns: [
            // {
            //     "className":      'details-control',
            //     "orderable":      false,
            //     "data":           null,
            //     "defaultContent": ''
            // },
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'},
            {data: 'nota_media', name: 'fac_alunos_notas.nota_media'},
            {data: 'codigoTurma', name: 'fac_turmas.codigo'},
            {data: 'nomeSituacao', name: 'fac_situacao_nota.nome'},
        ]
    });

    // array de detalhes da grid
    var detailRows = [];

    // evento para criação dos detalhes da grid
    $('#grid-cursadas').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableCursadas.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( formatCursadas( row.data() ) ).show();

            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );

    // On each draw, loop over the `detailRows` array and show any child rows
    tableDebitosFechados.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

    return tableDebitosFechados;
}


// Função para executar a grid
function runFinanceiro(idAluno) {
    // Carregando a grid de ACursar
    if(tableDebitosAbertos) {
        loadTableDebitosAbertos(idAluno).ajax.url("/index.php/seracademico/financeiro/aluno/gridDebitosAbertos/" + idAluno).load();
    } else {
        loadTableDebitosAbertos(idAluno);
    }

    // Carregando a grid de cursadas
    // if(tableCursadas) {
    //     loadTableCursadas(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridCursadas/" + idAluno).load();
    // } else {
    //     loadTableCursadas(idAluno);
    // }

    // carregando a modal
    $("#modal-debitos").modal({show:true});
}