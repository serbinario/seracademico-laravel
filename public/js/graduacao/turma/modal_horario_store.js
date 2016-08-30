// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#btnAdicionarHorario", function () {
    loadFields();
});

// carregando todos os campos preenchidos
function loadFields()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Disciplina|disciplinasOfTurma,' + idTurma,
            'Sala',
            'Dia|diasValidos,' + idTurma,
            'Professor|getValues'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/turma/horario/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {;
        // Verificando o retorno da requisição
        if(retorno['graduacao\\disciplina'].length > 0) {
            builderHtmlFields(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            //$('#modal-disciplina-store').modal('hide');
            swal("Desculpe não existe disciplinas disponíveis", "Click no botão abaixo!", "error");

        }
    });
};

// Função a montar o html
function builderHtmlFields (dados) {
    // limpando os campos
    $("#disciplina_horario_id").find("option").eq(0).prop("selected", true);
    $("#sala_id").find("option").eq(0).prop("selected", true);
    $("#dia_id").find("option").eq(0).prop("selected", true);
    $("#hora_id").find("option").remove();
    $("#professor_id").find("option").eq(0).prop("selected", true);

    // Variáveis que armazenaram o html
    var htmlDisciplina = "";
    var htmlsala       = "<option value=''>Selecione uma Sala</option>";
    var htmlDia        = "<option value=''>Selecione um dia</option>";
    var htmlHora       = "";
    var htmlprofessor  = "<option value=''>Selecione um Professor</option>";

    // Percorrendo o array de disciplinacurriculo
    for(var i = 0; i < dados['graduacao\\disciplina'].length; i++) {
        // Criando as options
        htmlDisciplina += "<option value='" + dados['graduacao\\disciplina'][i].id + "'>" + dados['graduacao\\disciplina'][i].codigo + " : " + dados['graduacao\\disciplina'][i].nome + "</option>";
    }

    // Percorrendo o array de salas
    for(var i = 0; i < dados['sala'].length; i++) {
        // Criando as options
        htmlsala += "<option value='" + dados['sala'][i].id + "'>" + dados['sala'][i].nome + "</option>";
    }

    // Reordenando os dias
    dados['dia'] = dados['dia'].sort(function (d1, d2) { return d1.id - d2.id });

    // Percorrendo o array de dias
    for(var i = 0; i < dados['dia'].length; i++) {
        // Criando as options
        htmlDia += "<option value='" + dados['dia'][i].id + "'>" + dados['dia'][i].nome + "</option>";
    }

    // Percorrendo o array de professores
    for(var i = 0; i < dados['professor'].length; i++) {
        // Criando as options
        htmlprofessor += "<option value='" + dados['professor'][i].id + "'>" + dados['professor'][i].nome + "</option>";
    }

    // Removendo e adicionando as options de disciplinas
    $("#disciplina_horario_id option").remove();
    $("#disciplina_horario_id").append(htmlDisciplina);

    // Removendo e adicionando as options de salas
    $("#sala_id option").remove();
    $("#sala_id").append(htmlsala);

    // Removendo e adicionando as options de dias
    $("#dia_id option").remove();
    $("#dia_id").append(htmlDia);

    // Removendo e adicionando as options de professores
    $("#professor_id option").remove();
    $("#professor_id").append(htmlprofessor);

    // Abrindo o modal de inserir disciplina
    $("#modal-horario-store").modal({show : true});
};

// evento para mudança no select de dia
$(document).on('change', '#dia_id', function () {
    // Recuperando o id do dia
    var idDia = $(this).find('option:selected').val();

    // Array de dados para consulta
    var dados = {
        'idTurma' : idTurma,
        'idDia'   : idDia
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/turma/horario/horasDisponiveis',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // variável de retorno
            var html = '';

            // Percorrento o array
            for(var i = 0; i < retorno.data.length; i++) {
                html += '<option value="' + retorno.data[i].id + '">' + retorno.data[i].nome + '</option>'
            }

            // preenchendo o select
            $("#hora_id option").remove();
            $("#hora_id").append(html);
        }
    });
});

// Evento para salvar tabela de preços
$('#btnStoreHorario').click(function() {
    var disciplina_id = $("#disciplina_horario_id").val();
    var dia_id        = $("#dia_id").val();
    var hora_id       = $("#hora_id").val();
    var professor_id  = $("#professor_id").val();

    var dados = {
        'idTurma' : idTurma,
        'disciplina_id': disciplina_id,
        'dia_id': dia_id,
        'hora_id': hora_id,
        'professor_id': professor_id,
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/turma/horario/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDisciplina.ajax.reload();
            tableHorario.ajax.reload();

            $('#modal-horario-store').modal('hide');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});