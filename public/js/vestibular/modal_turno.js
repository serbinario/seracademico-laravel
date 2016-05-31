// Função para carregar a grid
var tableTurno;
function loadTableTurno (idVestibularCurso) {
    tableTurno = $('#turno-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/vestibular/curso/turno/grid/" + idVestibularCurso,
        columns: [
            {data: 'nome', name: 'fac_turnos.nome'},
            {data: 'descricao', name: 'fac_vestibular_curso_turno.descricao'},
            {data: 'qtd_vagas', name: 'fac_vestibular_curso_turno.qtd_vagas'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableTurno;
}

// Função para executar a grid
function runTableTurno(idVestibularCurso) {
    if (tableTurno) {
        tableTurno.ajax.url( "/index.php/seracademico/vestibular/curso/turno/grid/" + idVestibularCurso).load();
    }

    loadTableTurno(idVestibularCurso);
}

// Evento para o click no botão de remover materia do curso do vestibular
$(document).on('click', '#removerCursoTurno', function () {
    var idTurno  = tableTurno.row($(this).parent().parent().index()).data().idTurno;
    var idCurso  = tableTurno.row($(this).parent().parent().index()).data().idCurso;

    var dadosAjax    = {
        'idTurno' : idTurno,
        'idVestibular' : idVestibular,
        'idCurso' : idCurso
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibular/curso/turno/delete',
        data: dadosAjax,
        datatype: 'json'
    }).done(function (retorno) {
        swal(retorno.msg, "Click no botão abaixo!", "success");
        tableTurno.ajax.reload();
        tableCurso.ajax.reload(function () {
            tableCurso.row(indexRowSelectedCurso).nodes().to$().find('td').addClass("row_selected");
        });
    });
});