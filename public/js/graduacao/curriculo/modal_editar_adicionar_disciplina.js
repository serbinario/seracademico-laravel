// Id do pivot de curriculo e disciplina
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
        'models' : [
            'Graduacao\\Disciplina|tipoNivelSistema,1,disciplinadefault'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/curriculo/getLoadFields',
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
        url: '/index.php/seracademico/graduacao/curriculo/disciplina/edit/' + idDisciplina + '/' + idCurriculo,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            // Setando os valores do model no formulário
            $('#disciplina_id_editar').html('<option value="' + retorno.data.disciplina_id +'">'+ retorno.data.codigoDisciplina + " : " + retorno.data.nomeDisciplina + '</option>');
            $('#periodo_editar option[value=' + retorno.data.periodo + ']').attr('selected', true);
            $('#carga_horaria_total_editar').val(retorno.data.carga_horaria_total);
            $('#carga_horaria_teorica_editar').val(retorno.data.carga_horaria_teorica);
            $('#carga_horaria_pratica_editar').val(retorno.data.carga_horaria_pratica);
            $('#qtd_credito_editar').val(retorno.data.qtd_credito);
            $('#qtd_faltas_editar').val(retorno.data.qtd_faltas);
            $('#carga_horaria_pratica_editar').val(retorno.data.carga_horaria_pratica);
            $('#pre_requisito_1_id_editar').html('<option value="' + retorno.data.pre_1_id +'">'+ retorno.data.pre_1_nome +'</option>');
            $('#pre_requisito_2_id_editar').html('<option value="' + retorno.data.pre_2_id +'">'+ retorno.data.pre_2_nome +'</option>');
            $('#pre_requisito_3_id_editar').html('<option value="' + retorno.data.pre_3_id +'">'+ retorno.data.pre_3_nome +'</option>');
            $('#pre_requisito_4_id_editar').html('<option value="' + retorno.data.pre_4_id +'">'+ retorno.data.pre_4_nome +'</option>');
            $('#pre_requisito_5_id_editar').html('<option value="' + retorno.data.pre_5_id +'">'+ retorno.data.pre_5_nome +'</option>');
            $('#co_requisito_1_id_editar').html('<option value="'  + retorno.data.co_1_id +'">'+ retorno.data.co_1_nome +'</option>');

            // Carregando o script dos select2
            $.getScript('/js/graduacao/curriculo/select2_requisitos.js', function() {});

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
    var periodo               = $("#periodo_editar").val();
    var carga_horaria_total   = $("#carga_horaria_total_editar").val();
    var carga_horaria_teorica = $("#carga_horaria_teorica_editar").val();
    var carga_horaria_pratica = $("#carga_horaria_pratica_editar").val();
    var qtd_credito           = $("#qtd_credito_editar").val();
    var qtd_faltas            = $("#qtd_faltas_editar").val();
    var pre_requisito_1_id    = $("#pre_requisito_1_id_editar").val();
    var pre_requisito_2_id    = $("#pre_requisito_2_id_editar").val();
    var pre_requisito_3_id    = $("#pre_requisito_3_id_editar").val();
    var pre_requisito_4_id    = $("#pre_requisito_4_id_editar").val();
    var pre_requisito_5_id    = $("#pre_requisito_5_id_editar").val();
    var co_requisito_1_id     = $("#co_requisito_1_id_editar").val();

    // Dados para a requisição
    var dados = {
        'periodo': periodo,
        'carga_horaria_total': carga_horaria_total,
        'carga_horaria_teorica' : carga_horaria_teorica,
        'carga_horaria_pratica' : carga_horaria_pratica,
        'qtd_credito' : qtd_credito,
        'qtd_faltas' : qtd_faltas,
        'pre_requisito_1_id' : pre_requisito_1_id,
        'pre_requisito_2_id' : pre_requisito_2_id,
        'pre_requisito_3_id' : pre_requisito_3_id,
        'pre_requisito_4_id' : pre_requisito_4_id,
        'pre_requisito_5_id' : pre_requisito_5_id,
        'co_requisito_1_id'  : co_requisito_1_id
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curriculo/disciplina/update/' + idDisciplina + '/' + idCurriculo,
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