// Função para carregar a grid
function loadTableDisciplina (idTurma) {
    tableDisciplina = $('#calendario-disciplina-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        ajax: "/seracademico-laravel/public/index.php/seracademico/posgraduacao/turma/calendario/grid/" + idTurma,
        columns: [
            {data: 'id', name: 'fac_turmas_disciplinas.id'},
            {data: 'nome', name: 'fac_disciplinas.nome'}
        ]
    });

    return tableDisciplina;
}

//Grid de disciplinas (modal de calendário da turma)
var tableCargaHoraria;
function runtableCargaHoraria () {
    tableCargaHoraria = $('#calendario-cargahoraria-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        ajax: "/seracademico-laravel/public/index.php/seracademico/posgraduacao/turma/calendario/gridCalendario/" + idTurmaDisciplina,
        columns: [
            {data: 'data', name: 'fac_calendarios.data'},
            {data: 'data_final', name: 'fac_calendarios.data_final'},
            {data: 'hora_inicial', name: 'fac_calendarios.hora_inicial'},
            {data: 'hora_final', name: 'fac_calendarios.hora_final'},
            {data: 'sala', name: 'fac_salas.nome'},
            {data: 'professor', name: 'fac_professores.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableCargaHoraria;
}

//Id da turma selecionada na grid de disciplina
var idTurmaDisciplina;

//evento quando clicar na linha da grid de disciplinas
$(document).on('click', '#calendario-disciplina-grid tbody tr', function () {
    // Verificando se existe linhas na tabela
    if (tableDisciplina.rows().data().length > 0) {
        $(this).parent().find("tr td").removeClass('row_selected');
        $(this).find("td").addClass("row_selected");

        //Ativando o botão de adicionar disciplina
        $("#btnAddCalendario").prop("disabled", false);

        //Recuperando o id da turma selecionada
        idTurmaDisciplina = tableDisciplina.row($(this).index()).data().id;

        var tableCargaHoraria = runtableCargaHoraria();
        tableCargaHoraria.ajax.url( "/seracademico-laravel/public/index.php/seracademico/posgraduacao/turma/calendario/gridCalendario/" + idTurmaDisciplina).load();
    }
});


// Função para executar a grid
function runTableDisciplina(idTurma) {
    $("#btnAddCalendario").attr("disabled", true);
    loadTableDisciplina().ajax.url( "/seracademico-laravel/public/index.php/seracademico/posgraduacao/turma/calendario/grid/" + idTurma).load();
    if(tableCargaHoraria != null) {
        tableCargaHoraria.ajax.url( "/seracademico-laravel/public/index.php/seracademico/posgraduacao/turma/calendario/gridCalendario/" + 0).load();
    }
}