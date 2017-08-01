$('#btnCancelarUpdateCalendario').click( function() {
    $('#modal-editar-calendario').modal('toggle');
});

//Remover calendário
$(document).on('click', '#btnRemoverCalendario', function () {
    //Recuperando o id do calendário
    var idCalendario = tableCargaHoraria.row($(this).parent().parent().index()).data().id;

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/doutorado/turma/calendario/delete/' + idCalendario,
        datatype: 'json'
    }).done(function (retorno) {
        tableCargaHoraria.load();

        if(tableCargaHoraria.rows().data().length == 1) {
            $("#btnAddCalendario").attr("disabled", true);
            tableDisciplina.load();
        }

        if(retorno.success) {
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para editar o calendário
$(document).on('click', '#btnEditarCalendario', function () {
    //Recuperando o id do calendário
    var idCalendario = tableCargaHoraria.row($(this).parent().parent().index()).data().id;

    //Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/doutorado/turma/calendario/edit/' + idCalendario,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            $('#data_editar').val(retorno.dados.calendario.data);
            $('#data_final_editar').val(retorno.dados.calendario.data_final);
            $('#hora_inicial_editar').val(retorno.dados.calendario.hora_inicial);
            $('#hora_final_editar').val(retorno.dados.calendario.hora_final);
            $('select#professor_id_editar option[value="' + retorno.dados.calendario.professor_id + '"]').prop('selected', true);
            $('select#sala_id_editar option[value="' + retorno.dados.calendario.sala_id + '"]').prop('selected', true);
            $('#idCalendario').val(retorno.dados.calendario.id_calendario);

            $('#modal-editar-calendario').modal({show: true, keyboard: true});
            $('#modal-editar-calendario').on('hidden.bs.modal', function (e) {
                $("#modal-disciplina-calendario").focus();
            });
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o update do calendario
$(document).on('click', '#btnUpdateCalendario', function () {
    var data         = $("#data_editar").val();
    var data_final   = $("#data_final_editar").val();
    var hora_inicial = $("#hora_inicial_editar").val();
    var hora_final   = $("#hora_final_editar").val();
    var sala_id      = $("#sala_id_editar").val();
    var professor_id = $("#professor_id_editar").val();
    var idCalendario = $("#idCalendario").val();

    var dados = {
        'data'         : data,
        'data_final'   : data_final,
        'hora_inicial' : hora_inicial,
        'hora_final'   : hora_final,
        'sala_id'      : sala_id,
        'professor_id' : professor_id,
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/doutorado/turma/calendario/update/' + idCalendario,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        $('#modal-editar-calendario').modal('toggle');
        tableCargaHoraria.ajax.reload();

        if(retorno.success) {
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});
