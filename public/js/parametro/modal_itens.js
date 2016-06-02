// Função para carregar a grid
var tableItens;
function loadTableItens (idParametro) {
    tableItens = $('#itens-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/parametro/itens/grid/" + idParametro,
        columns: [
            {data: 'nome', name: 'fac_parametros_itens.nome'},
            {data: 'valor', name: 'fac_parametros_itens.valor'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableItens;
}

// Função para executar a grid
function runTableItens(idParametro) {
    if (tableItens) {
        tableItens.ajax.url("/index.php/seracademico/parametro/itens/grid/" + idParametro).load();
    } else {
        loadTableItens(idParametro);
    }

    // exibindo a modal
    $("#modal-itens-parametros").modal({ show :true });
}

// Evento para o click no botão de remover curso do vestibular
$(document).on('click', '#btnRemoverItensParametros', function () {
    var idItem = tableItens.row($(this).parent().parent().parent().parent().parent().index()).data().id ;

    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/parametro/itens/delete/' + idItem,
        datatype: 'json'
    }).done(function (retorno) {
        swal(retorno.msg, "Click no botão abaixo!", "success");
        tableItens.ajax.reload();
        table.ajax.reload();
    });
});