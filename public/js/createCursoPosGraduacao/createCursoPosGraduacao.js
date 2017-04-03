/**
 * Created by serbinario on 29/03/17.
 */
function createCursoPosGraduacao(valor, nivel, idSelect) {

    if (!valor || !nivel) {
        return false;
    }

    //Persistindo o dado inserido
    $.ajax({
        type: 'POST',
        url: '/index.php/seracademico/cursoPosGraduacao/storeCursoPosGraduacao',
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