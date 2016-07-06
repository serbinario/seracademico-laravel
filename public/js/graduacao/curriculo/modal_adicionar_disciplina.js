/*Datatable da grid adicionar disciplina*/
var tableAdicionarDisciplina;
function loadTableAdicionarDisciplina (idCurriculo) {
    // Carregaando a grid
    tableAdicionarDisciplina = $('#add-disciplina-curriculo').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: {
            url: "/index.php/seracademico/graduacao/curriculo/gridByCurriculo/" + idCurriculo,
            data: function (d) {
                d.periodo = $('input[name=periodoSearch]').val();
            }
        },
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
            {data: 'qtd_faltas', name: 'fac_curriculo_disciplina.qtd_faltas'},
            {data: 'carga_horaria_total', name: 'fac_curriculo_disciplina.carga_horaria_total'},
            {data: 'carga_horaria_pratica', name: 'fac_curriculo_disciplina.carga_horaria_pratica'},
            {data: 'carga_horaria_teorica', name: 'fac_curriculo_disciplina.carga_horaria_teorica'},
            {data: 'qtd_credito', name: 'fac_curriculo_disciplina.qtd_credito'},
            {data: 'tipo_disciplina', name: 'fac_tipo_disciplinas.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#search-form').on('submit', function(e) {
        tableAdicionarDisciplina.draw();
        e.preventDefault();
    });

    // array de detalhes da grid
    var detailRows = [];

    // evento para criação dos detalhes da grid
    $('#add-disciplina-curriculo').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableAdicionarDisciplina.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();

            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );

    // On each draw, loop over the `detailRows` array and show any child rows
    tableAdicionarDisciplina.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

    // Retorno
    return tableAdicionarDisciplina;
}

// função para criação da linha de detalhe
function format ( d ) {
    return  '<div class="row">' +
                '<div class="row">' +
                    '<div class="col-md-12">' +
                        '<table id="detalhe-disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th>Pré-Requisito 1</th>' +
                                    '<th>Pré-Requisito 2</th>' +
                                    '<th>Co-Requisito 1</th>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                                '<tr>' +
                                    '<td>' + d.pre1Codigo+ '</td>' +
                                    '<td>' + d.pre2Codigo+ '</td>' +
                                    '<td>' + d.co1Codigo+ '</td>' +
                                '</tr>' +
                            '</tbody>' +
                        '</table>' +
                    '</div>' +
                '</div>' +
            '</div>';
}

// Executando a grid
function runTableAdicionarDisciplina (idCurriculo) {
    loadTableAdicionarDisciplina(idCurriculo).ajax.url("/index.php/seracademico/graduacao/curriculo/gridByCurriculo/" + idCurriculo).load();
}