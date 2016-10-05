// Variável que armazenará o id do aluno
var idAluno;

// Evento para chamar o modal de editar notas
$(document).on("click", "#btnEditPretensao", function () {
    idAluno = tableReport.row($(this).parent().parent().index()).data().id;
    loadFields();
});

// carregando todos os campos preenchidos
function loadFields()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'PosGraduacao\\TipoPretensao'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/posgraduacao/aluno/turma/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFields(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-editar-pretensao').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFields (dados) {
    // Fazendo a requisição 
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/aluno/editPretensao/' + idAluno,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            // Variáveis que armazenaram o html
            var htmlPretensao  = "";

            // Percorrendo o array de situacaonota
            for (var i = 0; i < dados['posgraduacao\\tipopretensao'].length; i++) {
                htmlPretensao += "<option value='" + dados['posgraduacao\\tipopretensao'][i].id + "'>" + dados['posgraduacao\\tipopretensao'][i].nome + "</option>";
            }

            // Preenchendo o select de situacaonota
            $("#tipo_pretensao_id option").remove();
            $("#tipo_pretensao_id").append(htmlPretensao);

            // Setando os valores do model no formulário
            $('#tipo_pretensao_id').find('option[value=' + retorno.dados.id + ']').attr('selected', true);

            // Abrindo o modal de inserir disciplina
            $("#modal-editar-pretensao").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdatePretensao').click(function() {
    // Recuperando valores do formulário
    var tipo_pretensao_id = $("#tipo_pretensao_id").val();

    // Preparando o array de dados
    var dados = {
        'tipo_pretensao_id': tipo_pretensao_id
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/aluno/updatePretensao/' + idAluno,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Mensagem
            swal('Pretensão alterada com sucesso!', 'Click no botão abaixo', 'success');

            // Recarregando a grid
            tableReport.ajax.reload();

            // Recarregando o gráfico
            loadGrafics();

            // Fechando o modal
            $('#modal-editar-pretensao').modal('toggle');
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});