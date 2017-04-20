/**
 * Created by serbinario on 29/03/17.
 */
function createInstituicao(valor, nivel, idSelect) {

    if (!valor || !nivel) {
        return false;
    }

    //Persistindo o dado inserido
    $.ajax({
        type: 'POST',
        url: '/index.php/seracademico/instituicao/storeInstituicao',
        data: {nome : valor, nivel : nivel},
        datatype: 'json'
    }).done(function(json) {

        var option ="";

        //Montando o option
        option += '<option value="' + json.dados.id + '">' + json.dados.nome + '</option>';

        //Injetando option no select2
        $(idSelect).append(option);
        $(idSelect).find("option[value=" + json.dados.id + "]").trigger("change");
    });
}