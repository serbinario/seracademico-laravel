// Id do plano de aula
var idPlanoAula;

// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#btnEditPlanoAula", function () {
    idPlanoAula = tablePlanoAula.row($(this).parents('tr')).data().id;
    loadFieldsPlanoAulaEditar();

    // Carregando a grid conteudos
    if(tableConteudoPlanoAulaEditar) {
        loadEditTableConteudoProgramaticoPlanoAulaEditar(idPlanoAula).ajax.url("/index.php/seracademico/graduacao/planoEnsino/planoAula/gridConteudos/" + idPlanoAula).load();
    } else {
        loadEditTableConteudoProgramaticoPlanoAulaEditar(idPlanoAula);
    }
});


// carregando todos os campos preenchidos
function loadFieldsPlanoAulaEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Professor|getValues',
            'Graduacao\\ConteudoProgramatico|byPlanoAula,' + idPlanoAula + ',' + idPlanoEnsino
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/planoEnsino/planoAula/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsPlanoAulaEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-edit-planos-aulas').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsPlanoAulaEditar (dados) {
    // Fazendo a requisição para recuperar os dados de plano de aula
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/planoEnsino/planoAula/edit/' + idPlanoAula,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            // Variáveis que armazenaram o html
            var htmlProfessor = "<option value=''>Selecione um Professor</option>";
            var htmlConteudo  = "<option value=''>Selecione um Conteudo</option>";

            // Percorrendo o array de cursos
            for (var i = 0; i < dados['professor'].length; i++) {
                htmlProfessor += "<option value='" + dados['professor'][i].id + "'>" + dados['professor'][i].nome + "</option>";
            }

            // Percorrendo o array de cursos
            for (var i = 0; i < dados['graduacao\\conteudoprogramatico'].length; i++) {
                htmlConteudo += "<option value='" + dados['graduacao\\conteudoprogramatico'][i].id + "'>" + dados['graduacao\\conteudoprogramatico'][i].nome + "</option>";
            }
            
            // Carregando os selects de professores
            $("#professor_1_id_editar option").remove();
            $("#professor_1_id_editar").append(htmlProfessor);
            $("#professor_2_id_editar option").remove();
            $("#professor_2_id_editar").append(htmlProfessor);
            $("#professor_3_id_editar option").remove();
            $("#professor_3_id_editar").append(htmlProfessor);
            $("#professor_4_id_editar option").remove();
            $("#professor_4_id_editar").append(htmlProfessor);
            $("#professor_5_id_editar option").remove();
            $("#professor_5_id_editar").append(htmlProfessor);
            $("#conteudo_plano_aula_editar option").remove();
            $("#conteudo_plano_aula_editar").append(htmlConteudo);

            // Setando os valores do model no formulário
            $('#professor_1_id_editar option[value=' + retorno.data.professor_1_id +']').attr('selected', true);
            $('#professor_2_id_editar option[value=' + retorno.data.professor_2_id +']').attr('selected', true);
            $('#professor_3_id_editar option[value=' + retorno.data.professor_3_id +']').attr('selected', true);
            $('#professor_4_id_editar option[value=' + retorno.data.professor_4_id +']').attr('selected', true);
            $('#professor_5_id_editar option[value=' + retorno.data.professor_5_id +']').attr('selected', true);
            $('#data_editar').val(retorno.data.data);
            $('#hora_inicial_editar').val(retorno.data.hora_inicial);
            $('#hora_final_editar').val(retorno.data.hora_final);
            $('#numero_aula_editar').val(retorno.data.numero_aula);
            
            // Abrindo o modal de inserir disciplina
            $("#modal-edit-planos-aulas").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdatePlanoAula').click(function() {
    // Recuperando os campos dos formulário
    var professor_1_id  = $("#professor_1_id_editar").val();
    var professor_2_id  = $("#professor_2_id_editar").val();
    var professor_3_id  = $("#professor_3_id_editar").val();
    var professor_4_id  = $("#professor_4_id_editar").val();
    var professor_5_id  = $("#professor_5_id_editar").val();
    var hora_inicial    = $("#hora_inicial_editar").val();
    var numero_aula     = $("#numero_aula_editar").val();
    var hora_final      = $("#hora_final_editar").val();
    var data            = $("#data_editar").val();

    // Dados a serem subimetidos
    var dados = {
        'plano_ensino_id': idPlanoEnsino,
        'professor_1_id' : professor_1_id,
        'professor_2_id' : professor_2_id,
        'professor_3_id' : professor_3_id,
        'professor_4_id' : professor_4_id,
        'professor_5_id' : professor_5_id,
        'hora_inicial'   : hora_inicial,
        'numero_aula'    : numero_aula,
        'hora_final'     : hora_final,
        'data'           : data
    };


    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/planoEnsino/planoAula/update/' + idPlanoAula,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tablePlanoAula.ajax.reload();
            $('#modal-edit-planos-aulas').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Função exclusiva para carregar o select de taxas
function loadFeldsConteudo() {
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\ConteudoProgramatico|byPlanoAula,' + idPlanoAula + ',' + idPlanoEnsino
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/planoEnsino/planoAula/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            var htmlConteudo = "<option value=''>Selecione um Conteúdo</option>";

            // Percorrendo o array de cursos
            for (var i = 0; i < retorno['graduacao\\conteudoprogramatico'].length; i++) {
                htmlConteudo += "<option value='" + retorno['graduacao\\conteudoprogramatico'][i].id + "'>" + retorno['graduacao\\conteudoprogramatico'][i].nome + "</option>";
            }

            // Carregado os selects
            $("#conteudo_plano_aula_editar option").remove();
            $("#conteudo_plano_aula_editar").append(htmlConteudo);
        }
    });
}