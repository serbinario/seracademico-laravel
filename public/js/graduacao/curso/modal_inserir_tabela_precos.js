// evento para abrir modal
$(document).on("click", "#adicionar-tabela-precos", function () {
    $("#modal-precos").modal({ show:true });

    // carregandos os campos pre-carregados
    loadFieldsTabela();
});

// carregando todos os campos preenchidos
function loadFieldsTabela()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Semestre',
            'Graduacao\\TipoPrecoCurso',
            'Turno'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/curso/precos/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsTabela(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-inserir-tabela-precos').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsTabela (dados) {
    // limpando os campos
    $("#virgencia").val("");

    // Variáveis que armazenaram o html
    var htmlSemestre    = "<option value=''>Selecione um Semestre</option>";
    var htmlTipoPreco  = "<option value=''>Selecione um Tipo</option>";
    var htmlTurno      = "<option value=''>Selecione um Turno</option>";

    // Percorrendo o array de situacaoaluno
    for(var i = 0; i < dados['graduacao\\semestre'].length; i++) {
        // Criando as options
        htmlSemestre += "<option value='" + dados['graduacao\\semestre'][i].id + "'>"  + dados['graduacao\\semestre'][i].nome + "</option>";
    }

    // Percorrendo o array de tipoprecoturno
    for(var i = 0; i < dados['graduacao\\tipoprecocurso'].length; i++) {
        // Criando as options
        htmlTipoPreco += "<option value='" + dados['graduacao\\tipoprecocurso'][i].id + "'>"  + dados['graduacao\\tipoprecocurso'][i].nome + "</option>";
    }

    // Percorrendo o array de tipoprecoturno
    for(var i = 0; i < dados['turno'].length; i++) {
        // Criando as options
        htmlTurno += "<option value='" + dados['turno'][i].id + "'>"  + dados['turno'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de período
    $("#semestre_id option").remove();
    $("#semestre_id").append(htmlSemestre);

    // Removendo e adicionando as options de tipo preco
    $("#tipo_preco_curso_id option").remove();
    $("#tipo_preco_curso_id").append(htmlTipoPreco);

    // Removendo e adicionando as options de tipo preco
    $("#turno_id option").remove();
    $("#turno_id").append(htmlTurno);

}

// Evento para salvar tabela de preços
$('#btnSalvarTabelaPrecos').click(function() {
    var virgencia     = $("#virgencia").val();
    var semestre_id   = $("#semestre_id").val();
    var turno_id     = $("#turno_id").val();
    var tipo_preco_curso_id = $("#tipo_preco_curso_id").val();

    var dados = {
        'curso_id': idCurso,
        'virgencia': virgencia,
        'semestre_id' : semestre_id,
        'tipo_preco_curso_id' : tipo_preco_curso_id,
        'turno_id' : turno_id
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curso/precos/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tablePrecosCurso.load();
            loadFields();
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnRemoverTabelaPreco', function () {
    var idPrecoCurso = tablePrecosCurso.row($(this).parent().parent().index()).data().id;

    var dadosAjax    = {
        'idPrecoCurso' : idPrecoCurso,
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curso/precos/delete',
        data: dadosAjax,
        datatype: 'json'
    }).done(function (retorno) {
        swal(retorno.msg, "Click no botão abaixo!", "success");

        //Desativando o botão de adicionar preço por disciplinas
        $("#btnAddPrecoDisciplina").prop("disabled", true);
        table.ajax.reload();
        tablePrecosCurso.load();
    });
});
