// Evento para remoção de um horário
$(document).on('click', '#btnRemoverHorario', function (event) {
    if(!idHora || !idDia) {
        swal('Você deve selecionar um horário!', "Click no botão abaixo!", "warning");
        return false;
    }

    // dados para envio
    var data = {
        'idHora' : idHora,
        'idDia' : idDia,
        'idTurma' : idTurma
    };

    // fazendo a consulta ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/turma/horario/delete',
        data: data,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDisciplina.ajax.reload();
            tableHorario.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});
