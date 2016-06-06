// Função para carregar a grid
var tableMateria;
function loadTableMateria (idVestibularCurso) {
    tableMateria = $('#materia-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/vestibular/curso/materia/grid/" + idVestibularCurso,
        columns: [
            {data: 'codigo', name: 'fac_materias.codigo'},
            {data: 'nome', name: 'fac_materia.nome'},
            // {data: 'peso', name: 'fac_vestibular_curso_materia.peso'},
            // {data: 'qtd_questoes', name: 'fac_vestibular_curso_materia.qtd_questoes'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableMateria;
}

// Função para executar a grid
function runTableMateria(idVestibularCurso) {
    //$("#btnAddCalendario").attr("disabled", true);
    if (tableMateria) {
        tableMateria.ajax.url( "/index.php/seracademico/vestibular/curso/materia/grid/" + idVestibularCurso).load();
    }

    loadTableMateria(idVestibularCurso);
}

// Evento para o click no botão de remover materia do curso do vestibular
$(document).on('click', '#removerCursoMateria', function () {
    var idMateria = tableMateria.row($(this).parent().parent().index()).data().idMateria;
    var idCurso   = tableMateria.row($(this).parent().parent().index()).data().idCurso;

    var dadosAjax    = {
        'idMateria' : idMateria,
        'idVestibular' : idVestibular,
        'idCurso' : idCurso
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibular/curso/materia/delete',
        data: dadosAjax,
        datatype: 'json'
    }).done(function (retorno) {
        swal(retorno.msg, "Click no botão abaixo!", "success");
        tableMateria.ajax.reload();
        tableCurso.ajax.reload(function () {
            tableCurso.row(indexRowSelectedCurso).nodes().to$().find('td').addClass("row_selected");
        });

    });
});