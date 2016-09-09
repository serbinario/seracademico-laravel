// Variável que armazenará o id do horário
var idHorarioEditar;

// Evento para chamar o modal de editar notas
$(document).on("click", "#btnEditarHorario", function () {
    // Verificando se o horário foi selecionado
    if(typeof idHora == "undefined" || typeof idDia == "undefined") {
        swal('Você deve selecionar um horário!', "Click no botão abaixo!", "warning");
        return false;
    }

    // Dando inicio a execução do fluxo
    loadFieldsHorarioEditar();
});

// carregando todos os campos preenchidos
function loadFieldsHorarioEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Disciplina|disciplinasOfTurma,' + idTurma,
            'Sala',
            'Dia',
            'Professor|getValues',
            'Hora'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/turma/notas/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsHorarioEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-horario-update').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsHorarioEditar (dados) {
    // Fazendo a requisição para recuperar os dados do curriculoDisciplina
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/turma/horario/edit/' + idTurma + "/" + idHora + "/" + idDia,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
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

            // Percorrendo o array de hora
            for(var i = 0; i < dados['hora'].length; i++) {
                // Criando as options
                htmlHora += "<option value='" + dados['hora'][i].id + "'>" + dados['hora'][i].nome + "</option>";
            }

            // Removendo e adicionando as options de disciplinas
            $("#disciplina_horario_id_editar option").remove();
            $("#disciplina_horario_id_editar").append(htmlDisciplina);

            // Removendo e adicionando as options de salas
            $("#sala_id_editar option").remove();
            $("#sala_id_editar").append(htmlsala);

            // Removendo e adicionando as options de dias
            $("#dia_id_editar option").remove();
            $("#dia_id_editar").append(htmlDia);

            // Removendo e adicionando as options de professores
            $("#professor_id_editar option").remove();
            $("#professor_id_editar").append(htmlprofessor);

            // Removendo e adicionando as options de professores
            $("#hora_id_editar option").remove();
            $("#hora_id_editar").append(htmlHora);

            // Carregando os campos
            $('#disciplina_horario_id_editar option[value=' + retorno.dados.disciplina_id  + ']').attr('selected', true);
            $('#dia_id_editar option[value=' + retorno.dados.dia_id  + ']').attr('selected', true);
            $('#hora_id_editar option[value=' + retorno.dados.hora_id  + ']').attr('selected', true);
            $('#sala_id_editar option[value=' + retorno.dados.sala_id  + ']').attr('selected', true);
            $('#professor_id_editar option[value=' + retorno.dados.professor_id  + ']').attr('selected', true);

            // Setando o id do horário
            idHorarioEditar = retorno.dados.id;

            // Abrindo o modal de inserir disciplina
            $("#modal-horario-update").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdateHorario').click(function() {
    // Recuperando valores do formulário
    var disciplina_id = $("#disciplina_horario_id_editar").val();
    var dia_id        = $("#dia_id_editar").val();
    var hora_id       = $("#hora_id_editar").val();
    var professor_id  = $("#professor_id_editar").val();
    var sala_id       = $("#sala_id_editar").val();

    // Preparando o array de dados
    var dados = {
        'idTurma' : idTurma,
        'disciplina_id': disciplina_id,
        'dia_id': dia_id,
        'hora_id': hora_id,
        'professor_id': professor_id,
        'sala_id' : sala_id,
        'edit' : true,
    };

    // Requisição de confirmação caso for junção de turmas
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/turma/horario/eJuncao',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Mensagem para o alert
            var msg = "Foi verificado a existência de um horário com a mesma disciplina, carga horária e professor." +
                " Esses casos são recomendados para junção de turmas, se esse não for o caso aconselhamos a não prosseguir" +
                " com a operação.";

            // Alerta para caso de junção de turma
            swal({
                    title: "Deseja realmente continuar ?",
                    text: msg,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, desejo continuar!",
                    closeOnConfirm: false
                },
                function() {
                    // Requisição ajax
                    jQuery.ajax({
                        type: 'POST',
                        url: '/index.php/seracademico/graduacao/turma/horario/update/' + idHorarioEditar,
                        data: dados,
                        datatype: 'json'
                    }).done(function (retorno) {
                        if(retorno.success) {
                            $('#modal-horario-update').modal('toggle');
                            swal(retorno.msg, "Click no botão abaixo!", "success");
                        } else {
                            swal(retorno.msg, "Click no botão abaixo!", "error");
                        }
                    });
                });
        }
    });
});