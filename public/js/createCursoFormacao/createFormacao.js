/**
 * Created by serbinario on 29/03/17.
 */
function createFormacao(valor, idArea, idSelect) {

    if (!valor || !idArea) {
        return false;
    }

    //Persistindo o dado inserido
    $.ajax({
        type: 'POST',
        url: '/index.php/seracademico/cursoFormacao/storeCursoFormacao',
        data: {nome : valor, fac_tipo_areas_id : idArea},
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