// Evento para o click no botão de incluir disciplinas
$(document).on('click', '#btnIncluirDisciplinas', function () {
    //Id da turma corrente
    var id = idTurma;

    //Recuperando as disciplinas e carregando a grid
    getDisciplinasOfCurriculoAndLoadGrid(id);
});

// Função que recupera as disciplinas do currículo e carrega na grid
function getDisciplinasOfCurriculoAndLoadGrid(idTurma)
{
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/doutorado/turma/calendario/disciplinas/' + idTurma,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            var html = "<option>Selecione uma disciplina</option>";
            for (var i = 0; i < retorno.dados.length; i++) {
                html += "<option value='" + retorno.dados[i].id  +"'>"  + retorno.dados[i].nome + "</option>";
            }

            $("#incluir-disciplinas option").remove();
            $("#incluir-disciplinas").append(html);
            $("#modal-incluir-disciplinas").modal({'show' : true, keyboard: true});
            $("#modal-incluir-disciplinas").on('hidden.bs.modal', function (e) {
                $("#modal-disciplina-calendario").focus();
            });
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para o botão voltar da modal de incluir disciplina
$(document).on('click', '#btnVoltarIncluirDisciplina', function () {
    $("#modal-disciplina-calendario").focus();
});

// Evento para inclusão de disciplinas do currículo na turma
$(document).on('click', '#btnIncluirDisciplina', function () {
    // Recuperando o id da disciplina
    var idDiscipina = $("#incluir-disciplinas").val();

    // Validando se a disciplinas foi selecionada
    if(!idDiscipina) {
        swal('Disciplina não selecionada!', 'Click nno botão abaixo', 'error')
    }

    // Confirmar operação e executar
    swal({
            title: "em certeza que deseja incluir essa disciplina na turma ?",
            text: "Você poderá estar dessincronizando as disciplinas!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, desejo incluir!",
            closeOnConfirm: false
        },
        function() {
            var dadosAjax = {
                'idDisciplina': idDiscipina,
                'idTurma': idTurma
            };

            jQuery.ajax({
                type: 'POST',
                url: '/index.php/seracademico/doutorado/turma/calendario/incluir',
                data: dadosAjax,
                datatype: 'json'
            }).done(function (retorno) {
                swal("Incluído!", "Disciplina incluída com sucesso.", "success");
                getDisciplinasOfCurriculoAndLoadGrid(idTurma);
                tableDisciplina.load();
            });
        });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#removerDisciplina', function () {

    var idDisciplina = tableDisciplina.row($(this).parents('tr').index()).data().idDisciplina;
    var dadosAjax    = {
        'idDisciplina' : idDisciplina,
        'idTurma'      : idTurma
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/doutorado/turma/calendario/remover-disciplina',
        data: dadosAjax,
        datatype: 'json'
    }).done(function (retorno) {
        swal(retorno.msg, "Click no botão abaixo!", "success");
        $("#btnAddCalendario").attr("disabled", true);
        tableDisciplina.load();
    });
});