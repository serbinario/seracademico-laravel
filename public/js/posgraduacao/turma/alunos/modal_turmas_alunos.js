// Função para carregar a grid
var tableAlunos;
function loadTableAlunos (idTurma) {
    tableAlunos = $('#alunos-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: {
            url: "/index.php/seracademico/posgraduacao/turma/alunos/grid/" + idTurma,
            data: function (d) {
                d.disciplina = $('select[name=disciplinaTurmaALunoSearch] option:selected').val();
                d.calendario = $('select[name=calendarioTurmaALunoSearch] option:selected').val();
            }
        },
        columns: [
            {data: 'nome', name: 'pessoas.nome'}
        ]
    });

    return tableAlunos;
}

// Função do submit do search da grid principal
$('#search-form-alunos').on('submit', function(e) {
    tableAlunos.draw();
    e.preventDefault();
});

// Função para executar a grid
function runTableAlunos(idTurma) {
    // Carregando as disciplinas da turma
    loadFieldsAlunos();

    if(tableCargaHoraria != null) {
        loadTableAlunos(idTurma).ajax.url( "/index.php/seracademico/posgraduacao/turma/alunos/grid/" + idTurma).load();
    } else {
        loadTableAlunos(idTurma);
    }
}

// carregando todos os campos preenchidos
function loadFieldsAlunos()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'PosGraduacao\\Disciplina|disciplinasOfTurma,' + idTurma
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/posgraduacao/turma/alunos/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            // Html de disciplinas
            var htmlDisciplina = "<option value=''>Selecione uma Disciplina</option>";

            // Percorrendo o array de disciplina
            for(var i = 0; i < retorno['posgraduacao\\disciplina'].length; i++) {
                // Criando as options
                htmlDisciplina += "<option value='" + retorno['posgraduacao\\disciplina'][i].id + "'>"  + retorno['posgraduacao\\disciplina'][i].nome + "</option>";
            }

            // Preenchendo o select
            $("#disciplinaTurmaALunoSearch option").remove();
            $("#disciplinaTurmaALunoSearch").append(htmlDisciplina);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-turmas-alunos').modal('toggle');
        }
    });
};

// Evento da mudança de disciplina
$(document).on('change', '#disciplinaTurmaALunoSearch', function () {
    // Recuperando o id da disciplina selecionada
    var idDisciplina = $(this).val();

    // Verificando se o valor é válido
    if(!idDisciplina) {
        return false;
    }

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/turma/getCalendariosByDisciplina/' + idTurma + '/' + idDisciplina,
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            // Html de disciplinas
            var htmlCalendario = "<option value=''>Selecione um Calendário</option>";

            // Percorrendo o array de disciplina
            for(var i = 0; i < retorno.dados.length; i++) {
                // Criando as options
                htmlCalendario += "<option value='" + retorno.dados[i].id + "'>"  + retorno.dados[i].data_final + "</option>";
            }

            // Preenchendo o select
            $("#calendarioTurmaALunoSearch option").remove();
            $("#calendarioTurmaALunoSearch").append(htmlCalendario);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-turmas-alunos').modal('toggle');
        }
    });
});