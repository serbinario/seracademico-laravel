// Variável que armazenará o id da nota
var idAlunoFrequencia;

// Evento para chamar o modal de editar frequencias
$(document).on("click", "#btnEditarFrequencias", function () {
    idAlunoFrequencia = tableFrequencias.row($(this).parent().parent().index()).data().id;
    builderHtmlFieldsFrequenciasEditar();
});

// Função a montar o html
function builderHtmlFieldsFrequenciasEditar () {
    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/turma/frequencias/edit/' + idAlunoFrequencia,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {

            // Setando os valores do model no formulário
            $('#nomePessoaFrequencia').val(retorno.data.nomePessoa).prop('disabled', true);
            $('#falta_mes_1').val(retorno.data.falta_mes_1);
            $('#falta_mes_2').val(retorno.data.falta_mes_2);
            $('#falta_mes_3').val(retorno.data.falta_mes_3);
            $('#falta_mes_4').val(retorno.data.falta_mes_4);
            $('#falta_mes_5').val(retorno.data.falta_mes_5);
            $('#falta_mes_6').val(retorno.data.falta_mes_6);
            $('#total_falta_frequencia').val(retorno.data.total_falta);

            // Abrindo o modal de inserir disciplina
            $("#modal-editar-frequencias").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdateFrequencias').click(function() {
    // Recuperando valores do formulário
    var falta_mes_1 = $("#falta_mes_1").val();
    var falta_mes_2 = $("#falta_mes_2").val();
    var falta_mes_3 = $("#falta_mes_3").val();
    var falta_mes_4 = $("#falta_mes_4").val();
    var falta_mes_5 = $("#falta_mes_5").val();
    var falta_mes_6 = $("#falta_mes_6").val();
    var total_falta = $("#total_falta_frequencia").val();

    // Preparando o array de dados
    var dados = {
        'falta_mes_1' : falta_mes_1,
        'falta_mes_2' : falta_mes_2,
        'falta_mes_3' : falta_mes_3,
        'falta_mes_4' : falta_mes_4,
        'falta_mes_5' : falta_mes_5,
        'falta_mes_6' : falta_mes_6,
        'total_falta' : total_falta
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/turma/frequencias/update/' + idAlunoFrequencia,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableFrequencias.ajax.reload();
            $('#modal-editar-frequencias').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});