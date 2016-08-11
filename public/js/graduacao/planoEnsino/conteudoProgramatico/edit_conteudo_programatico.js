// Evento para adicionar linhas para grid de taxas
$('#btnCreateConteudoEditar').on( 'click', function () {
    // Recuperando o valor do conteúdo
    var conteudo = $('#conteudo_programatico').val();
    
    // Verificando se foi passado valor válido
    if (!conteudo) {
        swal('Você deve criar um conteúdo!', "Click no botão abaixo!", 'error');
        return false;
    }

    // Limpando o campo de conteúdo
    $("#conteudo_programatico").val("");

    // Dados a serem subimetidos
    var dados = {
        'nome': conteudo,
        'plano_ensino_id': idPlanoEnsino
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/planoEnsino/storeConteudoProgramatico',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableConteudoProgramatico.ajax.reload();

            swal(retorno.msg, "Click no botão abaixo!", 'success');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", 'error');
        }
    });
} );

// Removendo a linha da grid
$(document).on( 'click', '#btnRemoverConteudoEditar', function () {
    // Recuperando o id od registro
    var conteudoId = tableConteudoProgramatico.row($(this).parent().parent()).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'DELETE',
        url: '/index.php/seracademico/graduacao/planoEnsino/deleteConteudoProgramatico/' + conteudoId,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableConteudoProgramatico.ajax.reload();

            swal(retorno.msg, "Click no botão abaixo!", 'success');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", 'error');
        }
    });
});
