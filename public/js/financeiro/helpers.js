/**
 * Função responsável por recuperar a taxa
 *
 * @param idTaxa
 */
function getInfoTaxa(idTaxa, callable)
{
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/financeiro/taxa/getTaxa/' + idTaxa,
        datatype: 'json'
    }).done(function (retorno) {
        callable(retorno);
    });
}