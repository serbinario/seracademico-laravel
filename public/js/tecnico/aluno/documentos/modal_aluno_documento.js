// carregando todos os campos preenchidos
function loadFieldsDocumentos()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Tecnico\\TipoDocumento|nivelDeMestrado'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/tecnico/aluno/turma/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsDocumento(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-aluno-documento').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDocumento (dados) {
    //Limpando os campos
    $('#documentacao_id option').attr('selected', false);
    
    // Variáveis que armazenaram o html
    var htmlDocumento     = "";

    // Percorrendo o array de cursos
    for (var i = 0; i < dados['tecnico\\tipodocumento'].length; i++) {
        htmlDocumento += "<option value='" + dados['tecnico\\tipodocumento'][i].id + "'>" + dados['tecnico\\tipodocumento'][i].nome + "</option>";
    }

    $("#documentacao_id option").remove();
    $("#documentacao_id").append(htmlDocumento);

    // Abrindo o modal de inserir disciplina
    $("#modal-aluno-documento").modal({show : true});
}

// Evento para gerar o documento
$(document).on('click', '#btnGerarDocumento', function () {
    // Recuperando os dados do formulário
    var documentacao_id = $('#documentacao_id').val();

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/tecnico/aluno/checkDocumento/'+ documentacao_id + "/" + idAluno,
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno.success) {
            // Executando o relatório e abrindo em outra aba
            window.open("/index.php/seracademico/tecnico/aluno/gerarDocumento/"
                + documentacao_id + "/" + idAluno, '_blank');
        } else {
            // Retorno caso retorno alguma erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});