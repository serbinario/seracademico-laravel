// Regras de validação
$(document).ready(function () {

    $("#formDisciplina").validate({
        rules: {
            nome: {
                required: true,
                maxlength: 80
            },

            codigo: {
                required: true,
                maxlength: 50
            },

            carga_horaria: {
                integer: true,
                maxlength: 2
            },

            qtd_falta: {
                integer: true,
                maxlength: 2
            },

            tipo_disciplina_id: {
                integer: true
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
            //console.log("Error");
            $(element).parent().parent().addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            //console.log("Sucess");
            $(element).parent().parent().removeClass("has-error");

        }
    });
});

/*<script type="text/javascript">
    $(document).ready(function () {
        console.log(Lang.getLocale());
        Lang.setLocale('pt-BR');

        $('#formDisciplina').bootstrapValidator({
         fields: {
         nome: {
         validators: {
         notEmpty: {
         message: Lang.get('validation.required', { attribute: 'Nome' })
         },
         stringLength: {
         max: 200,
         message: Lang.get('validation.max', { attribute: 'Nome' })
         }
         }
         },
         codigo: {
         validators: {
         notEmpty: {
         message: Lang.get('validation.required', { attribute: 'Código' })
         }
         }
         },
         carga_horaria: {
         validators: {
         stringLength: {
         max: 6,
         message: Lang.get('validation.max.numeric', { attribute: 'Carga Horária', max: '4' })
         }
         }
         },
         qtd_falta: {
         validators: {
         stringLength: {
         max: 4,
         message: Lang.get('validation.max', { attribute: 'Quantidade de Faltas' })
         }
         }
         }
         }
         });

    });*/