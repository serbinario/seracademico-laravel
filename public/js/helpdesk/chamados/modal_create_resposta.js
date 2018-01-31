$(document).on("click", "#btnNovaResposta", function () {
    builderHtmlFieldsResposta()
});

function builderHtmlFieldsResposta () {
    clearValueFieldsResposta();

    $('#modal-create-resposta').modal({show:true});
}

function clearValueFieldsResposta() {
    $("#descricao").val('');
    $("#status").find("option:selected").removeAttr("selected");
}

$(document).on("click", "#btnSavarResposta", function () {
    var dados = {
        'chamado_id': idChamado,
        'status': $('#status option:selected').val(),
        'descricao' : $('#descricao').val()
    };

    // Transação com banco de dados
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/helpdesk/chamados/respostas/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableRespostas.ajax.reload();
            $("#modal-create-resposta").modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});