// Função para carregar a grid
var tablePrecoDisciplinas;
function loadTablePrecoDisciplinas (idPrecoCurso) {
    tablePrecoDisciplinas = $('#grid-precos').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/curso/precos/gridPrecoDisciplinas/" + idPrecoCurso,
        columns: [
            {data: 'id', name: 'fac_precos_discplina_curso.id'},
            {data: 'preco', name: 'fac_precos_discplina_curso.preco'},
            {data: 'qtd_disciplinas', name: 'fac_precos_discplina_curso.qtd_disciplinas'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tablePrecoDisciplinas;
}

//evento quando clicar na linha da grid de disciplinas
$(document).on('click', '#grid-tabela-precos tbody tr', function () {
    // Verificando se existe linhas na tabela
    if (tablePrecosCurso.rows().data().length > 0) {
        $(this).parent().find("tr td").removeClass('row_selected');
        $(this).find("td").addClass("row_selected");

        //Ativando o botão de adicionar disciplina
        $("#btnAddCalendario").prop("disabled", false);

        //Recuperando o id da turma selecionada e o index da linha selecionada
        idTurmaDisciplina = tableDisciplina.row($(this).index()).data().id;
        indexRowSelectedDisciplina =  $(this).index();

        var tableCargaHoraria = runtableCargaHoraria();
        tableCargaHoraria.ajax.url( "/index.php/seracademico/posgraduacao/turma/calendario/gridCalendario/" + idTurmaDisciplina).load();
    }
});