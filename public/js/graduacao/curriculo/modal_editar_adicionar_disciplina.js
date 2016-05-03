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
            // Variáveis que armazenaram o html
            var htmlDisciplina     = "<option value=''>Selecione uma disciplina</option>";
            var htmlPreDisciplina1 = "<option value=''>Selecione uma disciplina</option>";
            var htmlPreDisciplina2 = "<option value=''>Selecione uma disciplina</option>";
            var htmlPreDisciplina3 = "<option value=''>Selecione uma disciplina</option>";
            var htmlPreDisciplina4 = "<option value=''>Selecione uma disciplina</option>";
            var htmlPreDisciplina5 = "<option value=''>Selecione uma disciplina</option>";
            var htmlCoDisciplina1  = "<option value=''>Selecione uma disciplina</option>";

            // Percorrendo o array de disciplinadefault
            for (var i = 0; i < dados['disciplinadefault'].length; i++) {
                htmlPreDisciplina1 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].nome + "</option>";
                htmlPreDisciplina2 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].nome + "</option>";
                htmlPreDisciplina3 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].nome + "</option>";
                htmlPreDisciplina4 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].nome + "</option>";
                htmlPreDisciplina5 += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].nome + "</option>";
                htmlCoDisciplina1  += "<option value='" + dados['disciplinadefault'][i].id + "'>"  + dados['disciplinadefault'][i].nome + "</option>";
            }

            $("#pre_disciplina_1_editar option").remove();
            $("#pre_disciplina_1_editar").append(htmlPreDisciplina1);

            $("#pre_disciplina_2_editar option").remove();
            $("#pre_disciplina_2_editar").append(htmlPreDisciplina2);

            $("#pre_disciplina_3_editar option").remove();
            $("#pre_disciplina_3_editar").append(htmlPreDisciplina3);

            $("#pre_disciplina_4_editar option").remove();
            $("#pre_disciplina_4_editar").append(htmlPreDisciplina4);

            $("#pre_disciplina_5_editar option").remove();
            $("#pre_disciplina_5_editar").append(htmlPreDisciplina5);

            $("#co_disciplina_1_editar option").remove();
            $("#co_disciplina_1_editar").append(htmlCoDisciplina1);

            // Setando os valores do model no formulário
            $('#disciplina_id_editar').html('<option value="' + retorno.data.disciplina_id + '">' + retorno.data.nomeDisciplina + '</option>');
            $('#periodo_editar option[value=' + retorno.data.periodo + ']').attr('selected', true);

            // Setando as disciplinas de pre requisitos
            $.each(retorno.data.preRequisitos, function (index, value) {
                switch (value.pivot.index) {
                    case 1 : $('#pre_disciplina_1_editar option[value=' + value.id + ']').attr('selected', true);break;
                    case 2 : $('#pre_disciplina_2_editar option[value=' + value.id + ']').attr('selected', true);break;
                    case 3 : $('#pre_disciplina_3_editar option[value=' + value.id + ']').attr('selected', true);break;
                    case 4 : $('#pre_disciplina_4_editar option[value=' + value.id + ']').attr('selected', true);break;
                    case 5 : $('#pre_disciplina_5_editar option[value=' + value.id + ']').attr('selected', true);break;
                }
            });

            // Setando as disciplinas de cos requisitos
            $.each(retorno.data.cosRequisitos, function (index, value) {
                switch (value.pivot.index) {
                    case 1 : $('#co_disciplina_1_editar option[value=' + value.id + ']').attr('selected', true);break;
                }
            });

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
    var idDisciplina     = $("#disciplina_id_editar").val();
    var periodo          = $("#periodo_editar").val();
    var dom_pre_discip   = $("select[name='pre_disciplinas_editar'] option:selected").toArray();
    var dom_co_discip    = $("select[name='co_disciplinas_editar'] option:selected").toArray();
    var pre_disciplina   = [];
    var co_disciplina    = [];

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
        'periodo': periodo,
        'pre_disciplina' : pre_disciplina,
        'co_disciplina' : co_disciplina
    };

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