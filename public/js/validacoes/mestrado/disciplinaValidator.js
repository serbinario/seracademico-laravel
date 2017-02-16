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