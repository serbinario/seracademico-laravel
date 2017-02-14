// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#posgraduacaoAddDisciplina", function () {
    loadFields();
});

// carregando todos os campos preenchidos
function loadFields()
{
    // Definindo os models
    var dados =  {
        'models' : []
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/posgraduacao/curriculo/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {// validado as disciplinas do currículo
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFields(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal("Desculpe não existe disciplinas disponíveis", "Click no botão abaixo!", "error");
            $('#modal-inserir-adicinar-disciplina').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFields (dados) {
    // limpando os campos
    $("#carga_horaria_total").val("");
    $("#qtd_credito").val("");
    $("#qtd_faltas").val("");
        
    // Carregando o script dos select2
    $.getScript('/js/posgraduacao/curriculo/select2_requisitos.js', function() {});

    // Abrindo o modal de inserir disciplina
    $("#modal-inserir-adicionar-disciplina").modal({show : true});
}

// Evento para salvar tabela de preços
$('#btnSalvarAdicionarDisciplina').click(function() {
    var disciplina_id         = $("#disciplina_id").val();
    var carga_horaria_total   = $("#carga_horaria_total").val();
    var qtd_credito           = $("#qtd_credito").val();
    var qtd_faltas            = $("#qtd_faltas").val();

    var dados = {
        'curriculo_id' : idCurriculo,
        'disciplina_id': disciplina_id,
        'carga_horaria_total': carga_horaria_total,
        'qtd_credito': qtd_credito,
        'qtd_faltas' : qtd_faltas
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/curriculo/disciplina/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableAdicionarDisciplina.load();
            $('#modal-inserir-adicionar-disciplina').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#removePosGraduacaoDisciplina', function () {
    var idDisciplina = tableAdicionarDisciplina.row($(this).parent().parent().index()).data().id;

    var dadosAjax    = {
        'idCurriculo'  : idCurriculo,
        'idDisciplina' : idDisciplina
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/curriculo/disciplina/delete',
        data: dadosAjax,
        datatype: 'json'
    }).done(function (retorno) {
        tableAdicionarDisciplina.ajax.reload();
        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});

// Evento para preencher os valores de carga horária e quantidade des
$("#disciplina_id").on('change', function () {
    // Recuperando o id da disciplina
    var idDisciplina = $(this).find('option:selected').val();

    // fazendo a consulta ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/curriculo/disciplina/get/' + idDisciplina,
        datatype: 'json'
    }).done(function (retorno) {
       if(retorno.success) {
           $("#carga_horaria_total").val(retorno.data.carga_horaria_total);
           $("#qtd_credito").val(retorno.data.qtd_credito);
           $("#qtd_faltas").val(retorno.data.qtd_faltas);
       }
    });
})
