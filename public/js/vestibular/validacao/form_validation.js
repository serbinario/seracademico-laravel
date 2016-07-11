// validação
$('#formVestibular').bootstrapValidator({
    fields: {
        data_inicial: {
            validators: {
                notEmpty: {
                    message: 'Campo Data Inicial é obrigatório'
                },
                date: {
                    max: 'data_final',
                    message: 'A data inicial deve ser menor ou igual a data final.'
                }
            }
        },
        data_final: {
            validators: {
                notEmpty: {
                    message: 'Campo Data Final é obrigatório'
                },
                date: {
                    min: 'data_inicial',
                    message: 'A data final deve ser maior ou igual a data inicial.'
                }
            }
        },
        hora_inicial: {
            validators: {
                notEmpty: {
                    message: 'Campo Hora Inicial é obrigatório'
                },
                regexp: {
                    regexp: '^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$',
                    message: 'Formato da hora não é válido. HH:mm:ss'
                }
            }
        },
        hora_final: {
            validators: {
                notEmpty: {
                    message: 'Campo Hora Final é obrigatório'
                },
                regexp: {
                    regexp: '^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$',
                    message: 'Formato da hora não é válido. HH:mm:ss'
                }
            }
        }
    }
}).on('success.field.fv', function(e, data) {
    // Revalidando a data final
    if (data.field === 'data_inicial' && !data.fv.isValidField('data_final')) {
        data.fv.revalidateField('data_final');
    }

    // Revalidando a data inicial
    if (data.field === 'data_final' && !data.fv.isValidField('data_inicial')) {
        data.fv.revalidateField('data_inicial');
    }
});
