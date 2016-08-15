// Função para carregar a grid
var tablePlanoAula;
function loadTablePlanoAula (idPlanoEnsino) {
    tablePlanoAula = $('#grid-planos-aulas').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/planoEnsino/planoAula/grid/" + idPlanoEnsino,
        columns: [
            // {
            //     "className":      'details-control',
            //     "orderable":      false,
            //     "data":           null,
            //     "defaultContent": ''
            // },
            {data: 'data', name: 'fac_planos_aulas.data'},
            {data: 'hora_inicial', name: 'fac_planos_aulas.hora_inicial'},
            {data: 'hora_final', name: 'fac_planos_aulas.hora_final'},
            {data: 'numero_aula', name: 'fac_planos_aulas.numero_aula'},
            {data: 'nomeProf1', name: 'pes1.nomeProf1'},
            // {data: 'nomeProf2', name: 'prof2.nomeProf1'},
            // {data: 'nomeProf3', name: 'prof3.nomeProf1'},
            // {data: 'nomeProf4', name: 'prof4.nomeProf1'},
            // {data: 'nomeProf5', name: 'prof5.nomeProf1'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // array de detalhes da grid
    var detailRows = [];

    // evento para criação dos detalhes da grid
    $('#grid-planos-aulas').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tablePlanoAula.row( tr );
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
    tablePlanoAula.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

    return tablePlanoAula;
}

// Função para executar a grid
function runPlanoAula(idPlanoEnsino) {
    // Carregando a grid de dispensadas
    if(tablePlanoAula) {
        loadTablePlanoAula(idPlanoEnsino).ajax.url("/index.php/seracademico/graduacao/planoEnsino/planoAula/grid/" + idPlanoEnsino).load();
    } else {
        loadTablePlanoAula(idPlanoEnsino);
    }

    // carregando a modal
    $("#modal-planos-aulas").modal({show:true});
}


// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDestroyPlanoAula', function () {
    // recuperando o id do aluno_semestre
    var idPlanoAula = tablePlanoAula.row($(this).parents('tr')).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'DELETE',
        url: '/index.php/seracademico/graduacao/planoEnsino/planoAula/delete/' + idPlanoAula,
        datatype: 'json'
    }).done(function (retorno) {
        tablePlanoAula.ajax.reload();
        
        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});