// carregando todos os campos preenchidos
function loadFieldsTabelaEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Periodo',
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
            builderHtmlFieldsTabelaEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-inserir-tabela-precos').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsTabelaEditar (dados) {
    // limpando os campos
    $("#virgencia_editar").val("");

    // Variáveis que armazenaram o html
    var htmlPeriodo    = "<option value=''>Selecione uma situação</option>";
    var htmlTipoPreco  = "<option value=''>Selecione uma situação</option>";
    var htmlTurno      = "<option value=''>Selecione uma situação</option>";

    // Percorrendo o array de situacaoaluno
    for(var i = 0; i < dados['graduacao\\periodo'].length; i++) {
        // Criando as options
        htmlPeriodo += "<option value='" + dados['graduacao\\periodo'][i].id + "'>"  + dados['graduacao\\periodo'][i].nome + "</option>";
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
    $("#periodo_id_editar option").remove();
    $("#periodo_id_editar").append(htmlPeriodo);

    // Removendo e adicionando as options de tipo preco
    $("#tipo_preco_curso_id_editar option").remove();
    $("#tipo_preco_curso_id_editar").append(htmlTipoPreco);

    // Removendo e adicionando as options de tipo preco
    $("#turno_id_editar option").remove();
    $("#turno_id_editar").append(htmlTurno);

}

// Evento para editar a tabela de preços
$(document).on('click', '#btnEditarTabelaPreco', function () {
    //carregando o formulário
    loadFieldsTabelaEditar();

    //Recuperando o id do calendário
    var idPrecoCurso = tablePrecosCurso.row($(this).parent().parent().index()).data().id;

    //Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/curso/precos/edit/' + idPrecoCurso,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            $('#virgencia_editar').val(retorno.dados.precoCurso.virgencia);
            $('select#curso_id_editar option[value="' + retorno.dados.precoCurso.curso_id + '"]').prop('selected', true);
            $('select#periodo_id_editar option[value="' + retorno.dados.precoCurso.periodo_id + '"]').prop('selected', true);
            $('select#tipo_preco_curso_id_editar option[value="' + retorno.dados.precoCurso.tipo_preco_curso_id + '"]').prop('selected', true);
            $('select#turno_id_editar option[value="' + retorno.dados.precoCurso.turno_id + '"]').prop('selected', true);
            $('#idPrecoCurso').val(retorno.dados.precoCurso.preco_curso_id);

            $('#editar-modal-precos').modal({show: true, keyboard: true});
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});


// Evento para update tabela de preços
$('#btnUpdateTabelaPrecos').click(function() {
    var idPrecoCurso = $("#idPrecoCurso").val();
    var virgencia    = $("#virgencia_editar").val();
    var periodo_id   = $("#periodo_id_editar").val();
    var turno_id     = $("#turno_id_editar").val();
    var tipo_preco_curso_id = $("#tipo_preco_curso_id_editar").val();

    var dados = {
        'curso_id': idCurso,
        'virgencia': virgencia,
        'periodo_id' : periodo_id,
        'tipo_preco_curso_id' : tipo_preco_curso_id,
        'turno_id' : turno_id
    };
    console.log(idPrecoCurso);
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/curso/precos/update/' + idPrecoCurso,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tablePrecosCurso.load();
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

