// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnAdicionarCursoTurno", function () {
    loadFieldsTurno();
});

// carregando todos os campos preenchidos
function loadFieldsTurno()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Turno|uniqueVestibularCurso,' + idVestibularCurso
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/vestibular/curso/turno/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno['turno'].length > 0) {
            builderHtmlFieldsTurno(retorno);
        } else {
            // Retorno caso não matéria disponível
            swal("Desculpe, não existe turno disponível", "Click no botão abaixo!", "error");
        }
    });
};

// Função a montar o html
function builderHtmlFieldsTurno (dados) {
    // limpando os campos
    $('#descricao').val("");
    $('#qtd_vagas').val("");

    // Variáveis que armazenaram o html
    var htmlTurno = "";

    // Percorrendo o array de disciplinacurriculo
    for(var i = 0; i < dados['turno'].length; i++) {
        // Criando as options
        htmlTurno += "<option value='" + dados['turno'][i].id + "'>" + dados['turno'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de período
    $("#turno_id option").remove();
    $("#turno_id").append(htmlTurno);

    // Abrindo o modal de inserir disciplina
    $("#modal-turno-store").modal({show : true});
};

// Evento para salvar tabela de preços
$('#btnSalvarCursoTurno').click(function() {
    // Recuperando os valores
    var turno_id   = $("#turno_id").val();
    var descricao  = $("#descricao").val();
    var qtd_vagas  = $("#qtd_vagas").val();

    // Dados ajax
    var dados = {
        'idCurso' : idCurso,
        'idVestibular' : idVestibular,
        'turno_id' : turno_id,
        'descricao': descricao,
        'qtd_vagas': qtd_vagas
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibular/curso/turno/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableTurno.ajax.reload();
            tableCurso.ajax.reload(function () {
                tableCurso.row(indexRowSelectedCurso).nodes().to$().find('td').addClass("row_selected");
            });

            // Fechando a modal
            $('#modal-turno-store').modal('hide');

            // Retorno
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            // Retorno
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});