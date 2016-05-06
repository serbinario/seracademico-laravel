// Função para carregar a grid
var tableHorario;
function loadTableHorario (idTurma) {
    tableHorario = $('#horario-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: "/index.php/seracademico/graduacao/turma/horario/grid/" + idTurma,
        columns: [
            {data: 'hora', name: 'fac_horas.id', orderable: false, searchable: false},
            {data: 'domingo', name: 'domingo', orderable: false, searchable: false},
            {data: 'segunda', name: 'segunda', orderable: false, searchable: false},
            {data: 'terca', name: 'terca', orderable: false, searchable: false},
            {data: 'quarta', name: 'quarta', orderable: false, searchable: false},
            {data: 'quinta', name: 'quinta', orderable: false, searchable: false},
            {data: 'sexta', name: 'sexta', orderable: false, searchable: false},
            {data: 'sabado', name: 'sabado', orderable: false, searchable: false}
        ]
    });

    return tableHorario;
}

//Grid de disciplinas (modal de calendário da turma)
//var tableCargaHoraria;
//function runtableCargaHoraria () {
//    tableCargaHoraria = $('#calendario-cargahoraria-grid').DataTable({
//        processing: true,
//        serverSide: true,
//        retrieve: true,
//        iDisplayLength: 5,
//        bLengthChange: false,
//        bFilter: false,
//
//        ajax: "/index.php/seracademico/posgraduacao/turma/calendario/gridCalendario/" + idTurmaDisciplina,
//        columns: [
//            {data: 'data', name: 'fac_calendarios.data'},
//            {data: 'data_final', name: 'fac_calendarios.data_final'},
//            {data: 'hora_inicial', name: 'fac_calendarios.hora_inicial'},
//            {data: 'hora_final', name: 'fac_calendarios.hora_final'},
//            {data: 'sala', name: 'fac_salas.nome'},
//            {data: 'professor', name: 'fac_professores.nome'},
//            {data: 'action', name: 'action', orderable: false, searchable: false}
//        ]
//    });
//
//    return tableCargaHoraria;
//}

//Id da turma selecionada na grid de disciplina
//var idTurmaDisciplina;
//
////evento quando clicar na linha da grid de disciplinas
//$(document).on('click', '#calendario-disciplina-grid tbody tr', function () {
//    // Verificando se existe linhas na tabela
//    if (tableDisciplina.rows().data().length > 0) {
//        $(this).parent().find("tr td").removeClass('row_selected');
//        $(this).find("td").addClass("row_selected");
//
//        //Ativando o botão de adicionar disciplina
//        $("#btnAddCalendario").prop("disabled", false);
//
//        //Recuperando o id da turma selecionada e o index da linha selecionada
//        idTurmaDisciplina = tableDisciplina.row($(this).index()).data().id;
//        indexRowSelectedDisciplina =  $(this).index();
//
//        var tableCargaHoraria = runtableCargaHoraria();
//        tableCargaHoraria.ajax.url( "/index.php/seracademico/posgraduacao/turma/calendario/gridCalendario/" + idTurmaDisciplina).load();
//    }
//});


// Função para executar a grid
function runTableHorario(idTurma) {
    //$("#btnAddCalendario").attr("disabled", true);
    if (tableHorario) {
        tableHorario.ajax.url( "/index.php/seracademico/graduacao/turma/horario/grid/" + idTurma).load();
    }

    loadTableHorario(idTurma);
    //if(tableCargaHoraria != null) {
    //    tableCargaHoraria.ajax.url( "/index.php/seracademico/posgraduacao/turma/horarrio/gridCalendario/" + 0).load();
    //}
}

// Evento para o click no botão de remover disciplina graduação
//$(document).on('click', '#removerDisciplina', function () {
//    var idDisciplina = tableDisciplina.row($(this).index()).data().idDisciplina;
//    var dadosAjax    = {
//        'idDisciplina' : idDisciplina,
//        'idTurma'      : idTurma
//    };
//
//    jQuery.ajax({
//        type: 'POST',
//        url: '/index.php/seracademico/graduacao/turma/disciplina/delete',
//        data: dadosAjax,
//        datatype: 'json'
//    }).done(function (retorno) {
//        swal(retorno.msg, "Click no botão abaixo!", "success");
//       // $("#btnAddCalendario").attr("disabled", true);
//        tableDisciplina.ajax.reload();
//    });
//});