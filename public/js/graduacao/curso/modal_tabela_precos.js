// Função para carregar a grid
var tablePrecosCurso;
function loadTablePrecosCurso (idCurso) {
    tablePrecosCurso = $('#grid-tabela-precos').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/curso/precos/grid/" + idCurso,
        columns: [
            {data: 'id', name: 'fac_precos_cursos.id'},
            {data: 'virgencia', name: 'fac_precos_cursos.virgencia'},
            {data: 'periodo', name: 'fac_periodos.periodo'},
            {data: 'tipo', name: 'fac_tipos_precos_cursos.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tablePrecosCurso;
}

// Função para executar a grid
function runTablePrecosCurso(idCurso) {
    loadTablePrecosCurso(idCurso).ajax.url("/index.php/seracademico/graduacao/curso/precos/grid/" + idCurso).load();
    $("#modal-tabela-precos").modal({show:true});
}
