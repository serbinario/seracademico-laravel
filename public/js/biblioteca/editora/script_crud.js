/**
 * Created by Fabio Aguiar on 20/03/2017.
 */

//Carregando as cidades
$(document).on('change', "#estado", function () {
    //Removendo as cidades
    $('#cidade option').remove();

    //Removendo as Bairros
    $('#bairro option').remove();

    //Recuperando o estado
    var estado = $(this).val();

    if (estado !== "") {
        var dados = {
            'table': 'cidades',
            'field_search': 'estados_id',
            'value_search': estado
        };

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/util/search",
            data: dados,
            datatype: 'json'
        }).done(function (json) {
            var option = "";

            option += '<option value="">Selecione uma cidade</option>';
            for (var i = 0; i < json.length; i++) {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }

            $('#cidade option').remove();
            $('#cidade').append(option);
        });
    }
});

//Carregando os bairros
$(document).on('change', "#cidade", function () {
    //Removendo as Bairros
    $('#bairro option').remove();

    //Recuperando a cidade
    var cidade = $(this).val();

    if (cidade !== "") {
        var dados = {
            'table': 'bairros',
            'field_search': 'cidades_id',
            'value_search': cidade
        };

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/util/search",
            data: dados,
            datatype: 'json'
        }).done(function (json) {
            var option = "";

            option += '<option value="">Selecione um bairro</option>';
            for (var i = 0; i < json.length; i++) {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }

            $('#bairro option').remove();
            $('#bairro').append(option);
        });
    }
});


//Validar nome duplicado
$(document).on('blur', "#nome", function () {

    //Recuperando o estado
    var nome = $(this).val();

    if (nome !== "") {
        var dados = {
            'nome': nome
        };

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/biblioteca/validarNome",
            data: dados,
            datatype: 'json'
        }).done(function (json) {
            var html = "";

            console.log(json['resultado']);

            if (json['resultado'] == true) {
                $('#nome').parent().addClass('has-feedback has-error');
                html = "<span class='help-block'>" + json['msg'] + "</span>";
                $('.help-block').remove();
                $('#nome').parent().append(html);
                $('.save').attr('disabled', true);
            } else {
                $('#nome').parent().removeClass('has-feedback has-error');
                $('.help-block').remove();
                $('.save').attr('disabled', false);
            }

        });
    }
});
