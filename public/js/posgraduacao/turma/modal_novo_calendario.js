$('#btnCancelarNovoCalendario').click( function() {
    $('#modal-novo-calendario').modal('toggle');
});

$('#btnSalvarCalendario').click(function() {
    var data         = $("#data").val();
    var data_final   = $("#data_final").val();
    var hora_inicial = $("#hora_inicial").val();
    var hora_final   = $("#hora_final").val();
    var sala_id      = $("#sala_id").val();
    var professor_id = $("#professor_id").val();

    var dados = {
        'turma_disciplina_id': idTurmaDisciplina,
        'data'               : data,
        'data_final'         : data_final,
        'hora_inicial'       : hora_inicial,
        'hora_final'         : hora_final,
        'sala_id'            : sala_id,
        'professor_id'       : professor_id,
    };

    jQuery.ajax({
        type: 'POST',
        url: '/seracademico-laravel/public/index.php/seracademico/posgraduacao/turma/calendario/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        $('#modal-novo-calendario').modal('toggle');
        tableCargaHoraria.load();

        if(retorno.success) {
            alert(retorno.msg);
        } else {
            alert(retorno.msg);
        }
    });
});




