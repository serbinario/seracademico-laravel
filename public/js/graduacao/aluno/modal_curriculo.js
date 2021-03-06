// Evento quando o modal fechar
$('#modal-curriculo').on('hidden.bs.modal', function () {
    loadTableACursar(0).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridACursar/" + 0).load();
    loadTableCursadas(0).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridCursadas/" + 0).load();
})

// Função para carregar a grid
var tableACursar;
function loadTableACursar (idAluno) {
    tableACursar = $('#grid-acursar').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridACursar/" + idAluno,
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo', orderable: false},
            {data: 'codigo', name: 'fac_disciplinas.codigo',orderable: false},
            {data: 'nome', name: 'fac_disciplinas.nome', orderable: false},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria', orderable: false},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito', orderable: false}
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
    tableACursar.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

    return tableACursar;
}

// função para criação da linha de detalhe
function formatAcursar ( d ) {
    return  '<div class="row">' +
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
            '</div>';
}

// Função para carregar a grid
var tableCursadas;
function loadTableCursadas (idAluno) {
    tableCursadas = $('#grid-cursadas').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridCursadas/" + idAluno,
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
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
    tableCursadas.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

    return tableCursadas;
}

// função para criação da linha de detalhe
function formatCursadas ( d ) {
    return  '<div class="row">' +
                '<div class="col-md-12">' +
                    '<table id="detalhe-disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>1º Unid.</th>' +
                                '<th>2º Unid.</th>' +
                                '<th>2º Chamada</th>' +
                                '<th>Final</th>' +
                                '<th>Média</th>' +
                            '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                            '<tr>' +
                                '<td>' + d.nota_unidade_1+ '</td>' +
                                '<td>' + d.nota_unidade_2+ '</td>' +
                                '<td>' + d.nota_2_chamada+ '</td>' +
                                '<td>' + d.nota_final+ '</td>' +
                                '<td>' + d.nota_media+ '</td>' +
                            '</tr>' +
                        '</tbody>' +
                    '</table>' +
                '</div>' +
            '</div>' ;
}

// Função para carregar a grid
var tableDispensadas;
function loadTableDispensadas (idAluno) {
    tableDispensadas = $('#grid-dispensadas').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridDispensadas/" + idAluno,
        columns: [
            {data: 'nomeSemestre', name: 'fac_semestres.nome'},
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'nota_media', name: 'fac_alunos_semestres_disciplinas_dispensadas.media'},
            {data: 'carga_horaria', name: 'fac_alunos_semestres_disciplinas_dispensadas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_alunos_semestres_disciplinas_dispensadas.qtd_credito'},
            {data: 'motivo', name: 'fac_motivos.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableDispensadas;
}

// Função para carregar a grid
var tableCursando;
function loadTableCursando (idAluno) {
    tableCursando = $('#grid-cursando').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridCursando/" + idAluno,
        columns: [
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo', orderable: false},
            {data: 'codigo', name: 'fac_disciplinas.codigo', orderable: false},
            {data: 'nome', name: 'fac_disciplinas.nome', orderable: false},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria', orderable: false},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito', orderable: false},
            {data: 'nota_media', name: 'fac_alunos_notas.nota_media', orderable: false},
            {data: 'codigoTurma', name: 'fac_turmas.codigo', orderable: false},
            {data: 'nomeSituacao', name: 'fac_situacao_nota.nome', orderable: false},
        ]
    });


    return tableCursando;
}

// Função para carregar a grid
var tableExtraCurricular;
function loadTableExtraCurricular (idAluno) {
    tableExtraCurricular = $('#grid-extras').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridExtraCurricular/" + idAluno,
        columns: [
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'},
            {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableExtraCurricular;
}

// Função para carregar a grid
var tableEletiva;
function loadTableEletiva (idAluno) {
    tableEletiva = $('#grid-eletivas').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridEletiva/" + idAluno,
        columns: [
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'},
            {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
            {data: 'codigoEletiva', name: 'eletiva.codigo'},
            {data: 'codigoCurriculoEletiva', name: 'curriculoEletiva.codigo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableEletiva;
}

// Função para carregar a grid
var tableEquivalencia;
function loadTableEquivalencia (idAluno) {
    tableEquivalencia = $('#grid-equivalencias').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridEquivalencia/" + idAluno,
        columns: [
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'},            
            {data: 'codigoEquivalencia', name: 'equivalente.codigo'},
            {data: 'codigoCurriculoEquivalencia', name: 'curriculoEquivalencia.codigo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableEquivalencia;
}

// Função para executar a grid
function runCurriculo(idAluno) {
    // Carregando a grid de ACursar
    if(tableACursar) {
        loadTableACursar(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridACursar/" + idAluno).load();
    } else {
        loadTableACursar(idAluno);
    }

    // Carregando a grid de cursadas
    if(tableCursadas) {
        loadTableCursadas(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridCursadas/" + idAluno).load();
    } else {
        loadTableCursadas(idAluno);
    }

    // Carregando a grid de dispensadas
    if(tableDispensadas) {
        loadTableDispensadas(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridDispensadas/" + idAluno).load();
    } else {
        loadTableDispensadas(idAluno);
    }

    // Carregando a grid de Cursando
    if(tableCursando) {
        loadTableCursando(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridCursando/" + idAluno).load();
    } else {
        loadTableCursando(idAluno);
    }

    // Carregando a grid de extras
    if(tableExtraCurricular) {
        loadTableExtraCurricular(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridExtraCurricular/" + idAluno).load();
    } else {
        loadTableExtraCurricular(idAluno);
    }

    // Carregando a grid de eletivas
    if(tableEletiva) {
        loadTableEletiva(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridEletiva/" + idAluno).load();
    } else {
        loadTableEletiva(idAluno);
    }

    // Carregando a grid de eletivas
    if(tableEquivalencia) {
        loadTableEquivalencia(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridEquivalencia/" + idAluno).load();
    } else {
        loadTableEquivalencia(idAluno);
    }

    // carregando a modal
    $("#modal-curriculo").modal({show:true});
}