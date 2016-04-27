//Desativando o botão de adicionar preço por disciplinas
$("#btnAddPrecoDisciplina").prop("disabled", true);

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
            {data: 'virgencia', name: 'fac_precos_cursos.virgencia'},
            {data: 'periodo', name: 'fac_periodos.periodo'},
            {data: 'tipo', name: 'fac_tipos_precos_cursos.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tablePrecosCurso;
}

// Função para carregar a grid
var tablePrecosDisciplinaCurso;
function loadTablePrecosDisciplinaCurso (idPrecoCurso) {
    tablePrecosDisciplinaCurso = $('#grid-precos').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/curso/precos/disciplina/grid/" + idPrecoCurso,
        columns: [
            {data: 'qtd_disciplinas', name: 'fac_precos_discplina_curso.qtd_disciplinas'},
            {data: 'preco', name: 'fac_precos_discplina_curso.preco'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tablePrecosDisciplinaCurso;
}

// Função para executar a grid
function runTablePrecosCurso(idCurso) {
    loadTablePrecosCurso(idCurso).ajax.url("/index.php/seracademico/graduacao/curso/precos/grid/" + idCurso).load();
    $("#modal-tabela-precos").modal({show:true});
}

// Id da tabela de preço selecionada
var idPrecoCurso;

// Evento para carregar grid de precos por disciplinas
$(document).on('click', '#grid-tabela-precos tbody tr', function (event) {
    // Verificando se existe linhas na tabela
    if (tablePrecosCurso.rows().data().length > 0 && $(event.target).is("td")) {
        $(this).parent().find("tr td").removeClass('row_selected');
        $(this).find("td").addClass("row_selected");

        //Ativando o botão de adicionar disciplina
        $("#btnAddPrecoDisciplina").prop("disabled", false);

        //Recuperando o id da turma selecionada e o index da linha selecionada
        idPrecoCurso = tablePrecosCurso.row($(this).index()).data().id;
        indexRowSelectedPrecoCurso =  $(this).index();

        loadTablePrecosDisciplinaCurso(idPrecoCurso).ajax.url("/index.php/seracademico/graduacao/curso/precos/disciplina/grid/" + idPrecoCurso).load();
    }
});
