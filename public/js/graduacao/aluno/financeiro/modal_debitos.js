// Função para carregar a grid
var tableDebitos;
function loadTableDebitos (idAluno) {
    tableDebitos = $('#grid-debitos').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        //bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/financeiro/gridDebitos/" + idAluno,
        columns: [
            {data: 'nomeTaxa', name: 'fin_taxas.nome'},
            {data: 'data_vencimento', name: 'fin_debitos.data_vencimento'},
            {data: 'valor_debito', name: 'fin_debitos.valor_debito'},
            {data: 'situacaoBoleto', name: 'fin_status_gnet.nome'},
            {data: 'gnet_carnet_id', name: 'fin_carnes.gnet_carnet_id'},
            {data: 'pago', name: 'fin_debitos.pago'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableDebitos;
}

var tableCarnes;
function loadTableCarnes (idAluno) {
    tableCarnes = $('#grid-carnes').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/financeiro/gridCarnes/" + idAluno,
        columns: [
            {data: 'gnet_carnet_id', name: 'fin_carnes.gnet_carnet_id'},
            {data: 'data_criacao', name: 'fin_carnes.created_at'},
            {data: 'qtd_parcelas', name: 'qtd_parcelas', orderable: false, searchable: false},
            {data: 'nomeTaxa', name: 'nomeTaxa'},
            {data: 'valorTaxa', name: 'fin_taxas.valor'},
            {data: 'link', name: 'link', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableCarnes;
}

// Função para executar a grid
function runFinanceiro(idAluno) {
    if(tableDebitos) {
        loadTableDebitos(idAluno)
            .ajax
            .url("/index.php/seracademico/graduacao/aluno/financeiro/gridDebitos/" + idAluno)
            .load();
    } else {
        loadTableDebitos(idAluno);
    }

    if(tableCarnes) {
        loadTableCarnes(idAluno)
            .ajax
            .url("/index.php/seracademico/graduacao/aluno/financeiro/gridCarnes/" + idAluno)
            .load();
    } else {
        loadTableCarnes(idAluno);
    }

    // carregando a modal
    $("#modal-debitos").modal({show:true});
}

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnExcluirDebito', function () {
    var idDebito = tableDebitos.row($(this).parent().parent().parent().index()).data().id;

    swal({
            title: "Você tem certeza?",
            text: "Você não poderá reverter esta ação!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Sim, Tenho certeza!',
            cancelButtonText: "Não, Desejo cancelar!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                jQuery.ajax({
                    type: 'GET',
                    url: '/index.php/seracademico/graduacao/aluno/financeiro/deleteDebito/' + idDebito,
                    datatype: 'json'
                }).done(function (retorno) {
                    tableDebitos.ajax.reload();
                    swal(retorno.msg, "Click no botão abaixo!", "success");
                });
            } else {
                swal("Cancelado", "Esclusão não realizada :)", "error");
            }
        });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnExcluirCarne', function () {
    var idCarne = tableCarnes.row($(this).parent().parent().parent().index()).data().carne_id;

    swal({
            title: "Você tem certeza?",
            text: "Você não poderá reverter esta ação!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Sim, Tenho certeza!',
            cancelButtonText: "Não, Desejo cancelar!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                jQuery.ajax({
                    type: 'GET',
                    url: '/index.php/seracademico/graduacao/aluno/financeiro/deleteCarne/' + idCarne,
                    datatype: 'json'
                }).done(function (retorno) {
                    tableCarnes.ajax.reload();
                    tableDebitos.ajax.reload();
                    swal(retorno.msg, "Click no botão abaixo!", "success");
                });
            } else {
                swal("Cancelado", "Esclusão não realizada :)", "error");
            }
        });
});