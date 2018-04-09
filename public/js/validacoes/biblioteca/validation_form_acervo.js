/*$(document).ready(function () {
    $('#formAcervo').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            'titulo': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            },
            'assunto': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            },
            'cutter': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            },
            'cdd': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            },
            'tipos_acervos_id': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            }
        }
    });
});
*/

$('#cdd').focusout(function(event) {
    var cdd = $("#cdd").val();
    var id = {
        'cdd' : cdd,
    };


    $assunto = jQuery.ajax({
        type: 'GET',
        url: "/index.php/seracademico/util/autoPreencherAssunto",
        headers: {
            'X-CSRF-TOKEN': '{{  csrf_token() }}'
        },
        data: id,
        datatype: 'json'
    }).done(function (json) {
        console.log(json);

        $('#assunto').val(json.assunto);
    });

});



$('#assunto').focusout(function(event) {
    var assunto = $("#assunto").val();
    var id = {
        'assunto' : assunto,
    };


 jQuery.ajax({
        type: 'GET',
        url: "/index.php/seracademico/util/autoPreencherAssunto",
        headers: {
            'X-CSRF-TOKEN': '{{  csrf_token() }}'
        },
        data: id,
        datatype: 'json'
    }).done(function (json) {
        console.log(json);

        $('#cdd').val(json.cdd);
    });

});