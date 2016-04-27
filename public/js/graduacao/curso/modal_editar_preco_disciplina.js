// carregando todos os campos preenchidos
function loadFieldsEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/curso/precos/disciplina/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            //builderHtmlFieldsEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-inserir-tabela-precos').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsEditar (dados) {

}


// Evento para editar a tabela de preços
$(document).on('click', '#btnEditarPrecoDisciplinaCurso', function () {
    //carregando o formulário
    loadFieldsEditar();

    //Recuperando o id do calendário
    var idPrecoDisciplinaCurso = tablePrecosDisciplinaCurso.row($(this).parent().parent().index()).data().id;

    //Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/curso/precos/disciplina/edit/' + idPrecoDisciplinaCurso,
        datatype: 'json'
    }).done(function (retorno) {
        console.log(retorno);
        if(retorno.success) {
            $("#qtd_disciplinas_editar").val(retorno.dados.precoDisciplina.qtd_disciplinas);
            $("#preco_editar").val(retorno.dados.precoDisciplina.preco);
            $("#idPrecoDisciplina").val(retorno.dados.precoDisciplina.idPrecoDisciplina);

            $('#modal-editar-preco-disciplina').modal({show: true, keyboard: true});
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});


// Evento para update tabela de preços
$('#btnUpdatePrecoDisciplina').click(function() {
    var qtd_disciplinas = $("#qtd_disciplinas_editar").val();
    var preco = $("#preco_editar").val();
    var idPrecoDisciplina = $("#idPrecoDisciplina").val();

    var dados = {
        'qtd_disciplinas': qtd_disciplinas,
        'preco': preco
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curso/precos/disciplina/update/' + idPrecoDisciplina,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tablePrecosDisciplinaCurso.load();
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

