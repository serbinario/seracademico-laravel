// Função que recupera as disciplinas do currículo e carrega na grid
function getDisciplinasOfCurriculoAndLoadGrid(idTurma)
{
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/turma/calendario/disciplinas/' + idTurma,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            var html = "";
            for (var i = 0; i < retorno.dados.length; i++) {
                html += "<tr>";
                html += "<td style='display:none;'>" + retorno.dados[i].id + "</td>";
                html += "<td>" + retorno.dados[i].codigo + "</td>";
                html += "<td style='width: 200%;'>" + retorno.dados[i].nome + "</td>";
                html += "</tr>";
            }

            $("#table-incluir-disciplinas tbody tr").remove();
            $("#table-incluir-disciplinas tbody").append(html);
            $("#modal-incluir-disciplinas").modal({'show' : true, keyboard: true});
            $("#modal-incluir-disciplinas").on('hidden.bs.modal', function (e) {
                $("#modal-disciplina-calendario").focus();
            });
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para o click no botão de incluir disciplinas
$(document).on('click', '#btnIncluirDisciplinas', function () {
    //Id da turma corrente
    var id = idTurma;

    //Recuperando as disciplinas e carregando a grid
    getDisciplinasOfCurriculoAndLoadGrid(id);
});

// Evento para o botão voltar da modal de incluir disciplina
$(document).on('click', '#btnVoltarIncluirDisciplina', function () {
    $("#modal-disciplina-calendario").focus();
});

// Marcando a linha selecionada
$(document).on('click', '#table-incluir-disciplinas tbody tr', function () {
    $(this).parent().find("tr td").removeClass('row_selected');
    $(this).find("td").addClass("row_selected");
});

// Evento para inclusão de disciplinas do currículo na turma
$(document).on('dblclick', '#table-incluir-disciplinas tbody tr', function () {
    var trSelected = $(this);

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
            var idDiscipina = $(trSelected).find('td').eq(0).text();
            var dadosAjax = {
                'idDisciplina': idDiscipina,
                'idTurma': idTurma
            };

            jQuery.ajax({
                type: 'POST',
                url: '/index.php/seracademico/posgraduacao/turma/calendario/incluir',
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
    //Id da turma corrente e disciplina selecionada
    var id = idTurma;
    console.log(tableDisciplina.row($(this).index()).data());
    var idDisciplina = tableDisciplina.row($(this).index()).data().idDisciplina;
    var dadosAjax    = {
        'idDisciplina' : idDisciplina,
        'idTurma'      : idTurma
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/turma/calendario/remover-disciplina',
        data: dadosAjax,
        datatype: 'json'
    }).done(function (retorno) {
        swal(retorno.msg, "Click no botão abaixo!", "success");
        $("#btnAddCalendario").attr("disabled", true);
        tableDisciplina.load();
    });
});