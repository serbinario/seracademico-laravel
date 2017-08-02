var tableConteudoProgramaticoDiarioAulaEdit;

// Função para carregamento da grid dtaxas
function loadTableConteudoProgramaticoDiarioAulaEdit() {
    // Inicializando a grid de taxas do benefício
    tableConteudoProgramaticoDiarioAulaEdit = $('#conteudo-programatico-diario-aula-grid-edit').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/doutorado/turma/diarioAula/gridConteudoProgramatico/" + idDiarioAula,
        columns: [
            {data: 'nome', name: 'nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableConteudoProgramaticoDiarioAulaEdit;
}

// Evento para adicionar linhas para grid de taxas
$('#btnAddConteudoProgramaticoDiarioAulaEdit').on( 'click', function () {
    // Recuperando o id da taxa
    var conteudos = $('#conteudo_programatico_diario_aula_edit').find('option:selected').val();

    if (!conteudos) {
        swal('Você deve escolher uma taxa!', "Click no botão abaixo!", 'error');
        return false;
    }

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/doutorado/turma/diarioAula/attachConteudo/' + idDiarioAula,
        data: {'conteudos' : [conteudos]},
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Limpando a seleção
            $("#conteudo_programatico_diario_aula_edit").select2("val", "");

            tableConteudoProgramaticoDiarioAulaEdit.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", 'success');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", 'error');
        }
    });
} );

// Removendo a linha da grid
$(document).on( 'click', '#btnRemoverConteudoProgramaticoDiarioAulaEditar', function () {
    // Recuperando o id od registro
    var conteudo = tableConteudoProgramaticoDiarioAulaEdit.row($(this).parents('tr')).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/doutorado/turma/diarioAula/detachConteudo/' + idDiarioAula,
        data: {'conteudos' : [conteudo]},
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Limpando a seleção
            $("#conteudo_programatico_diario_aula_edit").select2("val", "");

            tableConteudoProgramaticoDiarioAulaEdit.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", 'success');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", 'error');
        }
    });
});