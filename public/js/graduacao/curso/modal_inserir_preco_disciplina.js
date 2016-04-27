// evento para abrir modal
$(document).on("click", "#btnAddPrecoDisciplina", function () {
    $("#modal-inserir-preco-disciplina").modal({ show:true });

    // carregandos os campos pre-carregados
    loadFields();
});

// carregando todos os campos preenchidos
function loadFields()
{
    // Definindo os models
    var dados =  {
        'models' : [
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/curso/precos/disciplina/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFields(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-inserir-tabela-precos').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFields (dados) {
    // limpando os campos
    $("#qtd_disciplinas").val("");
    $("#preco").val("");
}

// Evento para salvar tabela de preços
$('#btnSalvarPrecoDisciplina').click(function() {
    var qtd_disciplinas = $("#qtd_disciplinas").val();
    var preco = $("#preco").val();

    var dados = {
        'qtd_disciplinas': qtd_disciplinas,
        'preco': preco,
        'preco_curso_id' : idPrecoCurso,

    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curso/precos/disciplina/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tablePrecosCurso.load(function () {
                tablePrecosCurso.row(indexRowSelectedPrecoCurso).columns().nodes().to$().each(function () {
                    $(this).addClass("row_selected");
                });
            });
            tablePrecosDisciplinaCurso.load();
            builderHtmlFields();

            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnRemoverPrecoDisciplinaCurso', function () {
    var idPrecoDisciplinaCurso = tablePrecosDisciplinaCurso.row($(this).parent().parent().index()).data().id;

    var dadosAjax    = {
        'idPrecoDisciplinaCurso' : idPrecoDisciplinaCurso,
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curso/precos/disciplina/delete',
        data: dadosAjax,
        datatype: 'json'
    }).done(function (retorno) {
        tablePrecosCurso.load(function () {
            tablePrecosCurso.row(indexRowSelectedPrecoCurso).columns().nodes().to$().each(function () {
                $(this).addClass("row_selected");
            });
        });
        tablePrecosDisciplinaCurso.load();

        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});
