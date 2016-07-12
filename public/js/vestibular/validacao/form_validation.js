// validação
$('#formVestibular').bootstrapValidator({
    framework: 'bootstrap',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        data_inicial2: {
            validators: {
                notEmpty: {
                    message: 'Campo Data Inicial é obrigatório'
                },
                date: {
                    format: 'DD/MM/YYYY',
                    message: 'Data inválida.'
                }
            }
        },
        data_final2: {
            validators: {
                notEmpty: {
                    message: 'Campo Data Final é obrigatório'
                },
                date: {
                    format: 'DD/MM/YYYY',
                    message: 'Data inválida.'
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
});



// evento para validar o focus
$('#data_inicial2').focusin(function () {
    $('#data_inicial').val('');
});

// evento para validar o focus
$('#data_final2').focusin(function () {
    $('#data_final').val('');
});

// evento para validar a hora
$('#data_final').focusout(function () {
    // Recuperando as datas
    var data_inicial = $('#data_inicial').val().split('/');
    var data_final   = $('#data_final').val().split('/');

    // Verificando se as datas foram preenchidas
    if(data_inicial.length === 3 && data_final.length === 3) {
        // Criando as datas
        var objDataInicial = new Date(data_inicial[2], data_inicial[1], data_inicial[0]);
        var objDataFinal   = new Date(data_final[2], data_final[1], data_final[0]);

        // Validando
        if(objDataInicial > objDataFinal) {
            swal("Inválido", "A data inicial deve ser menor ou igual a data final!", "error");

            // Regra de negócio
            $('#data_inicial').val($('#data_final').val());
        }
    }
});

var options = {};
options.timePicker = false;
options.autoApply = true;
options.drops = "up";
options.locale = {
    direction: $('#rtl').is(':checked') ? 'rtl' : 'ltr',
    format: 'DD/MM/YYYY',
    separator: ' - ',
    applyLabel: 'Aplicar',
    cancelLabel: 'Cancelar',
    fromLabel: 'De',
    toLabel: 'Para',
    customRangeLabel: 'Custom',
    daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex','Sab'],
    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    firstDay: 1
};

$('#config-demo').daterangepicker(options, function(start, end, label) {
    console.log('New date range selected: ' + start.format('YYYY-MM-DD')
        + ' to ' + end.format('YYYY-MM-DD')
        + ' (predefined range: ' + label + ')');
});
