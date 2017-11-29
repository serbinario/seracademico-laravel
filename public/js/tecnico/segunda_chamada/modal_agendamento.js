// Função para carregar a grid
var tableDisciplina, idAgendamento;
function loadTableDisciplina (idAgendamento) {
    tableDisciplina = $('#agendamento-disciplina-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
       // bFilter: false,
        ajax: "/index.php/seracademico/tecnico/agendamentoaluno/griddisciplina/" + idAgendamento,
        columns: [
            {data: 'nome', name: 'fac_disciplinas.nome'},
        ]
    });

    return tableDisciplina;
}

//Grid de disciplinas (modal de calendário da turma)
var tableAluno;
function runtableAluno () {
    tableAluno = $('#agendamento-aluno-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/tecnico/agendamentoaluno/gridaluno/" + idAgendaDisciplina + '/' + idAgendamento,
        columns: [
            {data: 'nome', name: 'pessoas.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableAluno;
}

//Id da turma selecionada na grid de disciplina
var idAgendaDisciplina;

//evento quando clicar na linha da grid de disciplinas
$(document).on('click', '#agendamento-disciplina-grid tbody tr', function () {
    // Verificando se existe linhas na tabela
    if (tableDisciplina.rows().data().length > 0) {
        $(this).parent().find("tr td").removeClass('row_selected');
        $(this).find("td").addClass("row_selected");

        //Ativando o botão de adicionar disciplina
        $("#btnAddAluno").prop("disabled", false);

        //Recuperando o id da turma selecionada e o index da linha selecionada
        idAgendaDisciplina = tableDisciplina.row($(this).index()).data().id;
        indexRowSelectedDisciplina =  $(this).index();

        loadFieldsAlunos();

        var tableAluno = runtableAluno();
        tableAluno.ajax.url( "/index.php/seracademico/tecnico/agendamentoaluno/gridaluno/" + idAgendaDisciplina + '/' + idAgendamento).load();
    }
});

/*Responsável em abrir modal*/
$(document).on("click", '#addAluno', function () {

    var idAluno = $("#aluno").val();

    if (!idAluno && !idAgendaDisciplina && !idAgendamento) {
        return false
    }

    var dados = {
        'aluno_id' : idAluno,
        'disciplina_id' : idAgendaDisciplina,
        'agendamento_sc_id' : idAgendamento
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/tecnico/agendamentoaluno/store',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno['success']) {
            loadFieldsAlunos();
            $('#aluno').select2({ width: 360 });
            swal(retorno['msg'], "Click no botão abaixo!", "success");
            tableAluno.load();
        }
    });
});

//Remover aluno
$(document).on('click', '#btnRemoverAluno', function () {
    //Recuperando o id do calendário
    var idAluno = tableAluno.row($(this).parent().parent().index()).data().id;

    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/tecnico/agendamentoaluno/delete/' + idAluno,
        datatype: 'json'
    }).done(function (retorno) {
        tableAluno.load();

        if(tableAluno.rows().data().length == 1) {
            $("#btnAddAluno").attr("disabled", true);
            tableDisciplina.load();
        }

        if(retorno.success) {
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Função para executar a grid
function runTableDisciplina(idAgendamento) {
    $("#btnAddAluno").attr("disabled", true);
    loadTableDisciplina().ajax.url( "/index.php/seracademico/tecnico/agendamentoaluno/griddisciplina/" + idAgendamento).load();
    if(tableAluno != null) {
        tableAluno.ajax.url( "/index.php/seracademico/tecnico/agendamentoaluno/gridaluno/" + 0 + '/' + 0).load();
    }
}

// carregando todos os campos preenchidos
function loadFieldsAlunos()
{
    // pega o id do aluno
    $("#aluno option").remove();

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/tecnico/agendamentoaluno/getLoadFieldsAluno',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            // Html de disciplinas
            var html = "<option value=''>Selecione um aluno</option>";

            for (var i = 0; i < retorno.length; i++) {
                html += '<option value="' + retorno[i]['id'] + '">' + retorno[i]['nome'] + '</option>';
            }

            // Preenchendo o select
            $("#aluno option").remove();
            $("#aluno").append(html);
        }
    });
};
