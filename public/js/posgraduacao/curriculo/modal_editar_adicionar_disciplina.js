// Id do pivot de curriculo e disciplina teste
var idCurriculoDisciplina;

// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#editarAdicionarDisicplina", function () {
    idDisciplina = tableAdicionarDisciplina.row($(this).parent().parent().index()).data().id;
    loadFieldsEditar();
});

// carregando todos os campos preenchidos
function loadFieldsEditar()
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
            builderHtmlFieldsEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-editar-adicinar-disciplina').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsEditar (dados) {
    // Fazendo a requisição para recuperar os dados do curriculoDisciplina
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/curriculo/disciplina/edit/' + idDisciplina + '/' + idCurriculo,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            // Setando os valores do model no formulário
            $('#disciplina_id_editar').html('<option value="' + retorno.data.disciplina_id +'">'+ retorno.data.codigoDisciplina + " : " + retorno.data.nomeDisciplina + '</option>');
            $('#carga_horaria_total_editar').val(retorno.data.carga_horaria_total);
            $('#qtd_credito_editar').val(retorno.data.qtd_credito);
            $('#qtd_faltas_editar').val(retorno.data.qtd_faltas);

            // Carregando o script dos select2
            $.getScript('/js/posgraduacao/curriculo/select2_requisitos.js', function() {});

            // Abrindo o modal de inserir disciplina
            $("#modal-editar-adicionar-disciplina").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdateAdicionarDisciplina').click(function() {
    var idDisciplina          = $("#disciplina_id_editar").val();
    var carga_horaria_total   = $("#carga_horaria_total_editar").val();
    var qtd_credito           = $("#qtd_credito_editar").val();
    var qtd_faltas            = $("#qtd_faltas_editar").val();

    // Dados para a requisição
    var dados = {
        'carga_horaria_total': carga_horaria_total,
        'qtd_credito' : qtd_credito,
        'qtd_faltas' : qtd_faltas,
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/curriculo/disciplina/update/' + idDisciplina + '/' + idCurriculo,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableAdicionarDisciplina.load();
            $('#modal-editar-adicionar-disciplina').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});