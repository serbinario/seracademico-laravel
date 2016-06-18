// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDeleteSituacao', function () {
    // recuperando o id do aluno_semestre
    var idAlunoSituacao = tableSituacao.row($(this).parent().parent().index()).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/historico/situacao/delete/' + idAlunoSituacao,
        datatype: 'json'
    }).done(function (retorno) {
        tableSituacao.ajax.reload();
        tableHistorico.ajax.reload(function () {
            tableHistorico.row(indexRowSelectedHistorico).nodes().to$().find('td').addClass("row_selected");
        });

        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});