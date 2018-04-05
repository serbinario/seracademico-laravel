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
    console.log("batata");
    var id = {
        'cdd' : 'a',
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

    $('#assunto').val('json.aaa');
    });





$('#assunto').val('batata');
});