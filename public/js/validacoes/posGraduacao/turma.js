// Regras de validação
$(document).ready(function () {

    $("#formTurma").validate({
        rules: {
            curso_id: {
                required: true,
                maxlength: 1
            },

            codigo: {
                required: true,
                maxlength: 100
            },

            turno_id: {
                required: true,
                integer: true
            },

            duracao_meses: {
                integer: true
            },

            sede_id: {
                required: true,
                integer: true
            },

            matricula_inicio: {
                maxlength: 12
            },

            matricula_fim: {
                maxlength: 12
            },

            aula_inicio: {
                maxlength: 12
            },

            aula_final: {
                maxlength: 12
            },

            valor_turma: {
                maxlength: 12
            },

            valor_disciplina: {
                maxlength: 12
            },

            qtd_parcelas: {
                integer: true,
                maxlength: 12
            },

            vencimento_inicial: {
                maxlength: 12
            },

            maximo_vagas: {
                integer: true,
                maxlength: 12
            },

            minimo_vagas: {
                integer: true,
                maxlength: 12
            },

            observacao_vagas: {
                maxlength: 200
            },

            sala_id: {
                integer: true
            },

            obs_sala: {
                maxlength: 200
            }
        },
        //For custom messages
        /*messages: {
         nome_operadores:{
         required: "Enter a username",
         minlength: "Enter at least 5 characters"
         }
         },*/
        //Define qual elemento será adicionado
        errorElement : 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },

        highlight: function(element, errorClass) {
            //console.log(errorClass);
            $(element).parent().parent().addClass("has-error");
        },

        unhighlight: function(element, errorClass, validClass) {
            //console.log("Sucess");
            $(element).parent().parent().removeClass("has-error");
        },

        invalidHandler: function(error, validator) {
            var errors = validator.numberOfInvalids();

            if (errors > 0){
                swal(
                    'Existem campos com preenchimento incorreto',
                    'Click em OK para continuar',
                    'error'
                );
            }
        }
    });
});