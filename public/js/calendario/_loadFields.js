$(document).ready(function() {
//Função para alimentar select tipo de evento
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/calendarioAnual/selectTipoEvento',
        datatype: 'json'
    }).done(function (json) {
        console.log(json);
    })
});

/*//Função para listar as períodos
function periodos(id) {
    jQuery.ajax({
        type: 'POST',
        url: ('calendario.getPeriodo'),
        datatype: 'json',
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione um período</option>';
        for (var i = 0; i < json.length; i++) {
            if (json[i]['id'] == id) {
                option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }
        }

        $('#periodo option').remove();
        $('#periodo').append(option);
    });
}*/

/*
function diaLetivo(id) {
    jQuery.ajax({
        type: 'POST',
        url: "/index.php/seracademico/calendarioAnual/getDiaLetivo",
        datatype: 'json',
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione</option>';
        for (var i = 0; i < json.length; i++) {
            if (json[i]['id'] == id) {
                option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }
        }

        $('#diaLetivo option').remove();
        $('#diaLetivo').append(option);
    });
}*/
