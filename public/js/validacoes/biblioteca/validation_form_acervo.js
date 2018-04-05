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
    var dados = {
        'cdd' : 'a',
    };
     
     $.ajax({
                url: "/index.php/seracademico/util/autoPreencherAssunto/",
                data: {
                    dados: dados,
                },
                dataType: "json",
                type: "GET",
                success: function (data) {
                    /*swal(data['msg'], "Click no botão abaixo!", "success");
                    $('#nome').val("");
                    $('#sobrenome').val("");*/
                    //location.href = "/serbinario/calendario/index/";
                }
            });
$('#assunto').val('batata');
});