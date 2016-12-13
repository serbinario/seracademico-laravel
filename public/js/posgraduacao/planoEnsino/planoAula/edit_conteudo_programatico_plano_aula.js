// Evento para adicionar linhas para grid de taxas
$('#btnAddConteudoPlanoAulaEditar').on( 'click', function () {
    // Recuperando o id da taxa
    var idConteudo = $('#conteudo_plano_aula_editar').find('option:selected').val();

    // Fazendo a verificação
    if (!idConteudo) {
        swal('Você deve escolher um conteúdo!', "Click no botão abaixo!", 'error');
        return false;
    }

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/planoEnsino/planoAula/attachConteudo/' + idPlanoAula,
        data: {'conteudos' : [idConteudo]},
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando o select de conteúdo
            loadFeldsConteudo();

            tableConteudoPlanoAulaEditar.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", 'success');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", 'error');
        }
    });
} );

// Removendo a linha da grid
$(document).on('click', '#btnDistroyPlanoAulaEditar', function () {
    // Recuperando o id od registro
    var idConteudo = tableConteudoPlanoAulaEditar.row($(this).parents('tr')).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/planoEnsino/planoAula/detachConteudo/' + idPlanoAula,
        data: {'conteudos' : [idConteudo]},
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando o select de conteúdo
            loadFeldsConteudo();

            tableConteudoPlanoAulaEditar.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", 'success');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", 'error');
        }
    });
});