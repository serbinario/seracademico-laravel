$(document).on("click", "#btnGerarBoleto", function () {
    var idDebito = tableDebitos.row($(this).parents('tr')).data().id;

    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/doutorado/aluno/financeiro/gerarBoleto/' + idDebito,
        datatype: 'json',
        beforeSend: function() {
            $(".carregamento").show();
            $('#btnGerarBoleto').attr('disabled', 'disabled');
        },
        complete: function() {
            $(".carregamento").hide();
            $('#btnGerarBoleto').removeAttr('disabled');
        }
    }).done(function (retorno) {
        if(retorno.success) {
            tableDebitos.ajax.reload();
            window.open(retorno.boleto.gnet_link,  '_blank');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});