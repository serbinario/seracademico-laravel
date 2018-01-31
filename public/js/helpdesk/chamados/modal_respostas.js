var tableRespostas;

function loadTableRespostas(idChamado) {
    tableRespostas = $('#respostas-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        //bLengthChange: false,
        //bFilter: false,
        //bPaginate: false,
        ajax: "/index.php/seracademico/helpdesk/chamados/respostas/grid/" + idChamado,
        columns: [
            {data: 'data', name: 'hp_respostas.created_at'},
            {data: 'name', name: 'users.name'},
            {data: 'descricao', name: 'hp_respostas.descricao'},
            {data: 'label_status', name: 'hp_respostas.status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableRespostas;
}

var idChamado;

$(document).on('click', '#btnModalRespostas', function () {
    idChamado = table.row($(this).parents('tr')).data().id;

    if(tableRespostas) {
        loadTableRespostas(idChamado).ajax.url("/index.php/seracademico/helpdesk/chamados/respostas/grid/" + idChamado).load();
    } else {
        loadTableRespostas(idChamado);
    }

    $("#modal-respostas").modal({show: true})
});

$(document).on('click', '#btnDestroyResposta', function () {
    var idResposta = tableRespostas.row($(this).parents('tr')).data().id;

    $.ajax({
        type: 'GET',
        url: '/index.php/seracademico/helpdesk/chamados/respostas/destroy/' + idResposta,
        datatype: 'JSON'
    }).done(function (retorno) {
        if(retorno.success) {
            tableRespostas.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});