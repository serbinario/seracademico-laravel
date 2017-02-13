$(document).ready(function () {
    $('#formAluno').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            'alunos[nomeAlunos]': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'alunos[cpfAlunos]': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
        }
    });
});
