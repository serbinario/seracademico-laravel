// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#graduacaoAddDisciplina", function () {
    loadFields();
});

// carregando todos os campos preenchidos
function loadFields()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Disciplina|uniqueDisciplina,' + idCurriculo,
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
        if(retorno['graduacao\\disciplina'].length > 0) {
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
    $("#periodo").find("option").eq(0).prop("selected", true);
    $("#carga_horaria_total").val("");
    $("#carga_horaria_teorica").val("");
    $("#carga_horaria_pratica").val("");
    $("#qtd_credito").val("");
    $("#qtd_faltas").val("");
        
    // Carregando o script dos select2
    $.getScript('/js/graduacao/curriculo/select2_requisitos.js', function() {});

    // Abrindo o modal de inserir disciplina
    $("#modal-inserir-adicionar-disciplina").modal({show : true});
}

// Evento para salvar tabela de preços
$('#btnSalvarAdicionarDisciplina').click(function() {
    var disciplina_id         = $("#disciplina_id").val();
    var periodo               = $("#periodo").val();
    var carga_horaria_total   = $("#carga_horaria_total").val();
    var carga_horaria_teorica = $("#carga_horaria_teorica").val();
    var carga_horaria_pratica = $("#carga_horaria_pratica").val();
    var qtd_credito           = $("#qtd_credito").val();
    var qtd_faltas            = $("#qtd_faltas").val();
    var dom_pre_discip        = $("select[name='pre_disciplinas'] option:selected").toArray();
    var dom_co_discip         = $("select[name='co_disciplinas'] option:selected").toArray();
    var pre_requisito_1_id    = $("#pre_requisito_1_id").val();
    var pre_requisito_2_id    = $("#pre_requisito_2_id").val();
    var pre_requisito_3_id    = $("#pre_requisito_3_id").val();
    var pre_requisito_4_id    = $("#pre_requisito_4_id").val();
    var pre_requisito_5_id    = $("#pre_requisito_5_id").val();
    var co_requisito_1_id     = $("#co_requisito_1_id").val();


    var dados = {
        'curriculo_id' : idCurriculo,
        'disciplina_id': disciplina_id,
        'periodo': periodo,
        'carga_horaria_total': carga_horaria_total,
        'carga_horaria_teorica' : carga_horaria_teorica,
        'carga_horaria_pratica' : carga_horaria_pratica,
        'qtd_credito': qtd_credito,
        'qtd_faltas' : qtd_faltas,
        'pre_requisito_1_id' : pre_requisito_1_id,
        'pre_requisito_2_id' : pre_requisito_2_id,
        'pre_requisito_3_id' : pre_requisito_3_id,
        'pre_requisito_4_id' : pre_requisito_4_id,
        'pre_requisito_5_id' : pre_requisito_5_id,
        'co_requisito_1_id'  : co_requisito_1_id
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curriculo/disciplina/store',
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
$(document).on('click', '#removeGraduacaoDisciplina', function () {
    var idDisciplina = tableAdicionarDisciplina.row($(this).parent().parent().index()).data().id;

    var dadosAjax    = {
        'idCurriculo'  : idCurriculo,
        'idDisciplina' : idDisciplina
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curriculo/disciplina/delete',
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
        url: '/index.php/seracademico/graduacao/curriculo/disciplina/get/' + idDisciplina,
        datatype: 'json'
    }).done(function (retorno) {
       if(retorno.success) {
           $("#carga_horaria_total").val(retorno.data.carga_horaria_total);
           $("#carga_horaria_teorica").val(retorno.data.carga_horaria_teorica);
           $("#carga_horaria_pratica").val(retorno.data.carga_horaria_pratica);
           $("#qtd_credito").val(retorno.data.qtd_credito);
           $("#qtd_faltas").val(retorno.data.qtd_faltas);
       }
    });
})
