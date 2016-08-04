// Função para carregar a grid
var tableBeneficios;
function loadTableBeneficios (idAluno) {
    tableBeneficios = $('#grid-beneficios').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/financeiro/aluno/beneficio/grid/" + idAluno,
        columns: [
            // {
            //     "className":      'details-control',
            //     "orderable":      false,
            //     "data":           null,
            //     "defaultContent": ''
            // },
            {data: 'nome', name: 'fin_tipos_beneficios.nome'},
            {data: 'valor', name: 'fin_Beneficios.valor'},
            {data: 'data_inicio', name: 'fin_Beneficios.data_inicio'},
            {data: 'data_fim', name: 'fin_Beneficios.data_fim'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // array de detalhes da grid
    var detailRows = [];

    // evento para criação dos detalhes da grid
    $('#grid-beneficios').on( 'click', 'tr td.details-control', function () {
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
    tableBeneficios.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

    return tableBeneficios;
}


// Função para executar a grid
function runBeneficio(idAluno) {
    // Carregando a grid de debitos
    if(tableBeneficios) {
        loadTableBeneficios(idAluno).ajax.url("/index.php/seracademico/financeiro/aluno/beneficio/grid/" + idAluno).load();
    } else {
        loadTableBeneficios(idAluno);
    }

    // carregando a modal
    $("#modal-beneficios").modal({show:true});
}

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDestroyBeneficio', function () {
    // Recuperando o id do benefício
    var idBeneficio = tableBeneficios.row($(this).parent().parent().index()).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'DELETE',
        url: '/index.php/seracademico/financeiro/aluno/beneficio/destroy/' + idBeneficio,
        datatype: 'json'
    }).done(function (retorno) {
        tableBeneficios.ajax.reload();
        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});