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

    // Variáveis que armazenaram o html
    var htmlDisciplina     = "<option value=''>Selecione uma disciplina</option>";
    var htmlPreDisciplina1 = "<option value=''>Selecione uma disciplina</option>";
    var htmlPreDisciplina2 = "<option value=''>Selecione uma disciplina</option>";
    var htmlPreDisciplina3 = "<option value=''>Selecione uma disciplina</option>";
    var htmlPreDisciplina4 = "<option value=''>Selecione uma disciplina</option>";
    var htmlPreDisciplina5 = "<option value=''>Selecione uma disciplina</option>";
    var htmlCoDisciplina1  = "<option value=''>Selecione uma disciplina</option>";

    // Percorrendo o array de disciplinacurriculo
    for(var i = 0; i < dados['graduacao\\disciplina'].length; i++) {
        // Criando as options
        htmlDisciplina     += "<option value='" + dados['graduacao\\disciplina'][i].id + "'>"  + dados['graduacao\\disciplina'][i].codigo + " : " + dados['graduacao\\disciplina'][i].nome + "</option>";
    }

    // Percorrendo o array de disciplinadefault
    for (var i = 0; i < dados['disciplinadefault'].length; i++) {
        htmlPreDisciplina1 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].codigo + " : " + dados['disciplinadefault'][i].nome + "</option>";
        htmlPreDisciplina2 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].codigo + " : " + dados['disciplinadefault'][i].nome + "</option>";
        htmlPreDisciplina3 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].nome + "</option>";
        htmlPreDisciplina4 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].codigo + " : " + dados['disciplinadefault'][i].nome + "</option>";
        htmlPreDisciplina5 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].codigo + " : " + dados['disciplinadefault'][i].nome + "</option>";
        htmlCoDisciplina1  += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].codigo + " : " + dados['disciplinadefault'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de período
    $("#disciplina_id option").remove();
    $("#disciplina_id").append(htmlDisciplina);

    $("#pre_disciplina_1 option").remove();
    $("#pre_disciplina_1").append(htmlPreDisciplina1);

    $("#pre_disciplina_2 option").remove();
    $("#pre_disciplina_2").append(htmlPreDisciplina2);

    $("#pre_disciplina_3 option").remove();
    $("#pre_disciplina_3").append(htmlPreDisciplina3);

    $("#pre_disciplina_4 option").remove();
    $("#pre_disciplina_4").append(htmlPreDisciplina4);

    $("#pre_disciplina_5 option").remove();
    $("#pre_disciplina_5").append(htmlPreDisciplina5);

    $("#co_disciplina_1 option").remove();
    $("#co_disciplina_1").append(htmlCoDisciplina1);

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
    var pre_disciplina        = [];
    var co_disciplina         = [];

    $(dom_pre_discip).each(function (index) {
        if($(this).val() != "") {
            pre_disciplina[index] = $(this).val();
        }

    });

    $(dom_co_discip).each(function (index) {
        if($(this).val() != "") {
            co_disciplina[index] = $(this).val();
        }
    });

    var dados = {
        'curriculo_id' : idCurriculo,
        'disciplina_id': disciplina_id,
        'periodo': periodo,
        'carga_horaria_total': carga_horaria_total,
        'carga_horaria_teorica' : carga_horaria_teorica,
        'carga_horaria_pratica' : carga_horaria_pratica,
        'qtd_credito': qtd_credito,
        'qtd_faltas' : qtd_faltas,
        'pre_disciplina' : pre_disciplina,
        'co_disciplina' : co_disciplina
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
