$('#btnCancelarUpdateCalendario').click( function() {
    $('#modal-editar-calendario').modal('toggle');
});

//Remover calendário
$(document).on('click', '#btnRemoverCalendario', function () {
    //Recuperando o id do calendário
    var idCalendario = tableCargaHoraria.row($(this).parent().parent().index()).data().id;

    jQuery.ajax({
        type: 'POST',
        url: '/seracademico-laravel/public/index.php/seracademico/posgraduacao/turma/calendario/delete/' + idCalendario,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableCargaHoraria.load();
            alert(retorno.msg);
        } else {
            alert(retorno.msg);
        }
    });
});

$(document).on('click', '#btnEditarCalendario', function () {
    //Recuperando o id do calendário
    var idCalendario = tableCargaHoraria.row($(this).parent().parent().index()).data().id;

    //Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/seracademico-laravel/public/index.php/seracademico/posgraduacao/turma/calendario/edit/' + idCalendario,
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

            $('#modal-editar-calendario').modal({show: true});
        } else {
            window.alert(retorno.msg);
        }
    });
});

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
        url: '/seracademico-laravel/public/index.php/seracademico/posgraduacao/turma/calendario/update/' + idCalendario,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        $('#modal-editar-calendario').modal('toggle');
        tableCargaHoraria.load();

        if(retorno.success) {
            alert(retorno.msg);
        } else {
            alert(retorno.msg);
        }
    });
});
