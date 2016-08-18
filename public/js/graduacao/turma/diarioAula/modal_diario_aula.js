// Função para carregar a grid
var tableDisciplinasDiarioAula;
function loadTableDisciplinasDiarioAula (idTurma) {
    tableDisciplinasDiarioAula = $('#diario-aula-disciplina-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/graduacao/turma/diarioAula/gridDisciplinas/" + idTurma,
        columns: [
            {data: 'codigo', name: 'fac_disciplinas.codigo', orderable: false},
            {data: 'nome', name: 'fac_disciplinas.nome', orderable: false}
        ]
    });

    return tableDisciplinasDiarioAula;
}

// Função para carregar a grid
var tableDiarioAula;
function loadTableDiarioAula (idTurmaDisciplina) {
    tableDiarioAula = $('#diario-aula-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/graduacao/turma/diarioAula/grid/" + idTurmaDisciplina,
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {data: 'numero_aula', name: 'fac_diarios_aulas.numero_aula'},
            {data: 'data', name: 'fac_diarios_aulas.data'},
            {data: 'carga_horaria', name: 'fac_diarios_aulas.carga_horaria'},
            {data: 'hora_inicial', name: 'fac_diarios_aulas.hora_inicial'},
            {data: 'hora_final', name: 'fac_diarios_aulas.hora_final'},
            {data: 'nome', name: 'pessoas.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // array de detalhes da grid
    var detailRows = [];

    // evento para criação dos detalhes da grid
    $('#diario-aula-grid').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableDiarioAula.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( formatDiarioAula( row.data() ) ).show();

            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );

    // On each draw, loop over the `detailRows` array and show any child rows
    tableDiarioAula.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

    return tableDiarioAula;
};


// função para criação da linha de detalhe
function formatDiarioAula ( d ) {
    return  '<div class="row">' +
                '<div class="col-md-12">' +
                    '<table id="assunto-ministrado-grid" class="display table table-bordered" cellspacing="0" width="100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>Assunto Ministrado</th>' +
                            '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                            '<tr>' +
                                '<td>' + d.assunto_ministrado + '</td>' +
                            '</tr>' +
                        '</tbody>' +
                    '</table>' +
                '</div>' +
            '</div>';
}

// Função para executar a grid
function runTableDiariosAulas(idTurma) {
    // Verificando se a grid está carregada
    if (tableDisciplinasDiarioAula) { 
        tableDisciplinasDiarioAula.ajax.url("/index.php/seracademico/graduacao/turma/diarioAula/gridDisciplinas/" + idTurma).load();
    } else {
        loadTableDisciplinasDiarioAula(idTurma);
    }

    // Desabilitando o botão de adicionar diário
    $('#btnCreateDiarioAula').prop('disabled', true);

    // exibindo o modal
    $('#modal-diario-aula').modal({show: true, keyboard: true});
}

//Variáveis úteis
var idTurmaDisciplinaDiarioAula, indexRowSelectedDisciplinaDiarioAula, idPlanoEnsinoDiarioAula;

// Evento quando clicar numa coluna
$(document).on('click', '#diario-aula-disciplina-grid tbody tr', function (event) {
    if (tableDisciplinasDiarioAula.rows().data().length > 0 && $(event.target).is("td")) {
        $(this).parent().find("tr td").removeClass('column_selected');
        $(this).find("td").addClass("column_selected");

        // Habilitando o botão de adicionar diário
        $('#btnCreateDiarioAula').prop('disabled', false);

        //Recuperando o id da turma selecionada e o index da linha selecionada
        idTurmaDisciplinaDiarioAula = tableDisciplinasDiarioAula.row($(this).index()).data().id;
        indexRowSelectedDisciplinaDiarioAula =  $(this).index();
        idPlanoEnsinoDiarioAula = tableDisciplinasDiarioAula.row($(this).index()).data().plano_ensino_id;

        loadTableDiarioAula(idTurmaDisciplinaDiarioAula).ajax.url( "/index.php/seracademico/graduacao/turma/diarioAula/grid/" + idTurmaDisciplinaDiarioAula).load();
    }
});

// Evento do fechamento da modal
$('#modal-diario-aula').on('hidden.bs.modal', function () {
    // Limpando a grid de diários de aulas
    loadTableDiarioAula(idTurmaDisciplinaDiarioAula).ajax.url( "/index.php/seracademico/graduacao/turma/diarioAula/grid/" + 0).load();
});
