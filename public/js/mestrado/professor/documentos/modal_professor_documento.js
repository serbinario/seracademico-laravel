// carregando todos os campos preenchidos
function loadFieldsDocumentos()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Mestrado\\TipoDocumentoProfessor|nivelDeMestrado'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/mestrado/professor/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsDocumento(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-professor-documento').modal('toggle');
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
    for (var i = 0; i < dados['mestrado\\tipodocumentoprofessor'].length; i++) {
        htmlDocumento += "<option value='" + dados['mestrado\\tipodocumentoprofessor'][i].id + "'>" + 
            dados['mestrado\\tipodocumentoprofessor'][i].nome + "</option>";
    }

    $("#documentacao_id option").remove();
    $("#documentacao_id").append(htmlDocumento);

    // Abrindo o modal de inserir disciplina
    $("#modal-professor-documento").modal({show : true});
}

// Evento para gerar o documento
$(document).on('click', '#btnGerarDocumento', function () {
    // Recuperando os dados do formulário
    var documentacao_id = $('#documentacao_id').val();

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/mestrado/professor/checkDocumento/'+ documentacao_id + "/" + idProfessor,
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno.success) {
            // Executando o relatório e abrindo em outra aba
            window.open("/index.php/seracademico/mestrado/professor/gerarDocumento/"
                + documentacao_id + "/" + idProfessor, '_blank');
        } else {
            // Retorno caso retorno alguma erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});