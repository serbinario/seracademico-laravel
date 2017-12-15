// Função para carregar a grid
var tableTurno;
function loadTableTurno (idInscricaoCurso) {
    tableTurno = $('#turno-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/tecnico/inscricao/curso/turno/grid/" + idInscricaoCurso,
        columns: [
            {data: 'nome', name: 'fac_turnos.nome'},
            {data: 'quantidade', name: 'pos_inscricoes_cursos_turnos.quantidade'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableTurno;
}

// Função para executar a grid
function runTableTurno(idInscricaoCurso) {
    if (tableTurno) {
        tableTurno.ajax.url( "/index.php/seracademico/tecnico/inscricao/curso/turno/grid/" + idInscricaoCurso).load();
    }

    loadTableTurno(idInscricaoCurso);
}

// Evento para o click no botão de remover materia do curso do vestibular
$(document).on('click', '#removerCursoTurno', function () {
    var idTurno  = tableTurno.row($(this).parent().parent().index()).data().idTurno;
    var idCurso  = tableTurno.row($(this).parent().parent().index()).data().idCurso;

    var dadosAjax    = {
        'idTurno' : idTurno,
        'idInscricao' : idInscricao,
        'idCurso' : idCurso
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/tecnico/inscricao/curso/turno/delete',
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