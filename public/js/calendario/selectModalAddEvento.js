/**
 * Created by serbinario on 06/04/17.
 */
    //Função para alimentar select dia letivo
$.ajax({
    type: 'GET',
    url: '/index.php/seracademico/calendarioAnual/selectDiaLetivo',
    datatype: 'json'
}).done(function (json) {
    var option = '';

    option += '<option value="">Selecione uma opção</option>';

    for (var i = 0; i < json.dados.length; i++) {
        option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['nome'] + '</option>';
    }

    $('#diaLetivo option').remove();
    $('#diaLetivo').append(option);
});