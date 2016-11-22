$(document).ready(function () {
    $('#FormExemplarP').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            'arcevos_id': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            },
            'issn': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            },
            'img': {
                validators: {
                    file: {
                        maxSize: 512000,   // 2048 * 1024
                        message: "Tamanho de imagem permitido é de até 500kb"
                    }
                }
            },
            'numero_pag': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            },
            'editoras_id': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            },
            'assunto_p': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    },
                },
            }
        }
    });
});
