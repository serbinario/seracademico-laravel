// Id da nota
var idNota;

// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#editarNotas", function () {
    idNota = tableNotas.row($(this).parent().parent()).data().id;
    builderHtmlFields(idNota);
});



// Função a montar o html
function builderHtmlFields (idNota) {
    // limpando os campos
    $("#codigo").attr('readonly', 'readonly');
    $("#materia").attr('readonly', 'readonly');

    var dados = {
        'idNota' : idNota,
        'idVestibulando' : idVestibulando
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibulando/notas/edit',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // preenchendo os campos
            $("#codigo").val(retorno.data.codigo);
            $("#materia").val(retorno.data.materia);
            $("#acertos").val(retorno.data.acertos);
            $("#pontuacao").val(retorno.data.pontuacao);

            $('#modal-nota-update').modal({show : true})
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
};

$(document).on('click', '#btnUpdateNotas', function () {
    var acertos   = $("#acertos").val();
    var pontuacao = $("#pontuacao").val();

    var dados = {
        'acertos' : acertos,
        'pontuacao' : pontuacao
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibulando/notas/update/' + idNota,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableNotas.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", "success");
            $('#modal-nota-update').modal('toggle');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

