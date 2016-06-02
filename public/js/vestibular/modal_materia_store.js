// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnAdicionarCursoMateria", function () {
    loadFieldsMateria();
});

// carregando todos os campos preenchidos
function loadFieldsMateria()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Materia|uniqueVestibularCurso,' + idVestibularCurso
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/vestibular/curso/materia/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno['graduacao\\materia'].length > 0) {
            builderHtmlFieldsMateria(retorno);
        } else {
            // Retorno caso não matéria disponível
            swal("Desculpe não existe matéria disponível", "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderHtmlFieldsMateria (dados) {
    // limpando os campos
    $('#periodo').val("");
    $('#qtd_questoes').val("");

    // Variáveis que armazenaram o html
    var htmlMateria     = "";

    // Percorrendo o array de disciplinacurriculo
    for(var i = 0; i < dados['graduacao\\materia'].length; i++) {
        // Criando as options
        htmlMateria += "<option value='" + dados['graduacao\\materia'][i].id + "'>" + dados['graduacao\\materia'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de período
    $("#materia_id option").remove();
    $("#materia_id").append(htmlMateria);

    // Abrindo o modal de inserir disciplina
    $("#modal-materia-store").modal({show : true});
};

// Evento para salvar tabela de preços
$('#btnSalvarCursoMateria').click(function() {
    // Recuperando os valores
    var materia_id   = $("#materia_id").val();
    var peso         = $("#peso").val();
    var qtd_questoes = $("#qtd_questoes").val();

    // Dados ajax
    var dados = {
        'idCurso' : idCurso,
        'idVestibular' : idVestibular,
        'materia_id' : materia_id,
        'peso': peso,
        'qtd_questoes': qtd_questoes,
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibular/curso/materia/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableMateria.ajax.reload();
            tableCurso.ajax.reload(function () {
                tableCurso.row(indexRowSelectedCurso).nodes().to$().find('td').addClass("row_selected");
            });

            // Fechando a modal
            $('#modal-materia-store').modal('hide');

            // Retorno
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            // Retorno
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});