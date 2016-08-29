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
        ajax: "/index.php/seracademico/financeiro/aluno/gridFechamentos/" + idAluno,
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
            {data: 'ano_referencia', name: 'fin_debitos.ano_referencia'}
            //{data: 'action', name: 'action', orderable: false, searchable: false}
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


// Função para carregar a grid
var tableBoletos;
function loadTableBoletos (idAluno) {
    tableBoletos = $('#grid-boletos').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/financeiro/aluno/gridBoletos/" + idAluno,
        columns: [
            // {
            //     "className":      'details-control',
            //     "orderable":      false,
            //     "data":           null,
            //     "defaultContent": ''
            // },
            {data: 'nosso_numero', name: 'fin_boletos.nosso_numero'},
            {data: 'vencimento', name: 'fin_boletos.vencimento'},
            {data: 'valor_debito', name: 'fin_debitos.valor_debito'},
            {data: 'data', name: 'fin_boletos.data'},
            {data: 'numero', name: 'fin_boletos.numero'}
            //{data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // array de detalhes da grid
    var detailRows = [];

    // evento para criação dos detalhes da grid
    $('#grid-boletos').on( 'click', 'tr td.details-control', function () {
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
    tableBoletos.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

    return tableBoletos;
}


// Função para executar a grid
function runFinanceiro(idAluno) {
    // Carregando a grid de debitos
    if(tableDebitosAbertos) {
        loadTableDebitosAbertos(idAluno).ajax.url("/index.php/seracademico/financeiro/aluno/gridDebitosAbertos/" + idAluno).load();
    } else {
        loadTableDebitosAbertos(idAluno);
    }

    //Carregando a grid de fechamentos
    if(tableDebitosFechados) {
        loadTableDebitosFechados(idAluno).ajax.url("/index.php/seracademico/financeiro/aluno/gridFechamentos/" + idAluno).load();
    } else {
        loadTableDebitosFechados(idAluno);
    }

    //Carregando a grid de boletos
    if(tableBoletos) {
        loadTableBoletos(idAluno).ajax.url("/index.php/seracademico/financeiro/aluno/gridBoletos/" + idAluno).load();
    } else {
        loadTableBoletos(idAluno);
    }

    // carregando a modal
    $("#modal-debitos").modal({show:true});
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
        url: '/index.php/seracademico/financeiro/aluno/storeBoleto',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno.success) {
            tableBoletos.ajax.reload();
            window.open('/index.php/seracademico/financeiro/aluno/gerarBoleto/' + retorno.data.id,  '_blank');
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });


});