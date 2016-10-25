// Evento para fechar modal
$(document).on('click', '#btnCloseModalFrequencias', function () {
    $('#disciplinaFrequenciasSearch option').remove();
});

// Função para carregar a grid
var tableFrequencias;
function loadTableFrequencias (idTurma) {
    tableFrequencias = $('#frequencias-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: {
            url: "/index.php/seracademico/posgraduacao/turma/frequencias/grid/" + idTurma,
            data: function (d) {
                d.disciplina = $('select[name=disciplinaFrequenciasSearch] option:selected').val();
            }
        },
        columns: [
            {data: 'nomePessoa', name: 'pessoas.nome'},
            {data: 'nome_disciplina', name: 'fac_disciplinas.nome'},
            {data: 'frequencia', name: 'frequencia', orderable: false, filterable: false}
        ]
    });

    // Função do submit do search da grid principal
    $('#frequencias-search-form').on('submit', function(e) {
        tableFrequencias.draw();
        e.preventDefault();
    });

    // retorno
    return tableFrequencias;
}

// Função para executar a grid
function runTableFrequencias(idTurma) {
    if (tableFrequencias) {
        tableFrequencias.ajax.url( "/index.php/seracademico/posgraduacao/turma/frequencias/grid/" + idTurma).load();
    } else {
        // Carregamento da grids
        loadTableFrequencias(idTurma);
    }

    // Carregamento os campos necessários
    loadFieldsFrequencias();

        
    // Configurações do modal
    $("#modal-frequencias-alunos").modal({show: true, keyboard: true});
}

// carregando todos os campos preenchidos
function loadFieldsFrequencias()
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
        url: '/index.php/seracademico/posgraduacao/turma/frequencias/getLoadFields',
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
            $("#disciplinaFrequenciasSearch option").remove();
            $("#disciplinaFrequenciasSearch").append(htmlDisciplina);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-alunos-frequencias').modal('toggle');
        }
    });
};

// Evento para cadastro de falta
$(document).on('click', '.frequencia', function () {
    var frequencia = $(this).prop('checked');
    var idFrequencia = $(this).val();
  
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'PUT',
        url: '/index.php/seracademico/posgraduacao/turma/frequencias/changeFrequencia/' + idFrequencia,
        data: {'frequencia' : frequencia},
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            swal(retorno.msg, 'Click no botão abaixo!', 'success');
        } else {
            swal(retorno.msg, 'Click no botão abaixo!', 'error');
        }
    });
});