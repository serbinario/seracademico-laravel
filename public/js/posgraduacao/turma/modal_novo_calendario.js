// Evento para cancelar
$('#btnCancelarNovoCalendario').click( function() {
    $('#modal-novo-calendario').modal('toggle');
});

// Evento abrir o modal
$('#btnAddCalendario').click( function() {
    // Abrindo o modal
    $('#modal-novo-calendario').modal({show:true});
});

// Evento para salvar
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
        'hora_inicial'       : hora_inicial + ':00',
        'hora_final'         : hora_final + ':00',
        'sala_id'            : sala_id,
        'professor_id'       : professor_id,
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/turma/calendario/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        $('#modal-novo-calendario').modal('toggle');
        tableCargaHoraria.load();
        tableDisciplina.ajax.reload(function () {
            $("#calendario-disciplina-grid tbody tr").eq(indexRowSelectedDisciplina).find("td").addClass("row_selected");
        });

        if(retorno.success) {
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});




