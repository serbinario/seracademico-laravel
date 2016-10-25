// Evento para fechar modal
$(document).on('click', '#btnCloseModalFrequencias', function () {
    $('#disciplinaFrequenciasSearch option').remove();
});

// Função para carregar a grid
var tableFrequencias;
function loadTableFrequencias (idTurma) {
    tableFrequencias = $('#alunos-frequencias-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: {
            url: "/index.php/seracademico/graduacao/turma/frequencias/grid/" + idTurma,
            data: function (d) {
                d.disciplina = $('select[name=disciplinaFrequenciasSearch] option:selected').val();
            }
        },
        columns: [
            {data: 'nomePessoa', name: 'pessoas.nome'},
            {data: 'falta_mes_1', name: 'fac_alunos_frequencias.falta_mes_1'},
            {data: 'falta_mes_2', name: 'fac_alunos_frequencias.falta_mes_2'},
            {data: 'falta_mes_3', name: 'fac_alunos_frequencias.falta_mes_3'},
            {data: 'falta_mes_4', name: 'fac_alunos_frequencias.falta_mes_4'},
            {data: 'falta_mes_5', name: 'fac_alunos_frequencias.falta_mes_5'},
            {data: 'falta_mes_6', name: 'fac_alunos_frequencias.falta_mes_6'},
            {data: 'total_falta', name: 'fac_alunos_frequencias.total_falta'},
            {data: 'nomeSituacao', name: 'fac_situacao_nota.nome'},
            {data: 'action', name: 'action'}
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
        tableFrequencias.ajax.url( "/index.php/seracademico/graduacao/turma/frequencias/grid/" + idTurma).load();
    } else {
        // Carregamento da grids
        loadTableFrequencias(idTurma);
    }

    // Carregamento os campos necessários
    loadFieldsFrequencias();

        
    // Configurações do modal
    $("#modal-frequencias-alunos").find('.modal-dialog').css("width", "97%");
    $("#modal-frequencias-alunos").find('.modal-dialog').css("max-height", "97%");
    $("#modal-frequencias-alunos").modal({show: true, keyboard: true});
}

// carregando todos os campos preenchidos
function loadFieldsFrequencias()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Disciplina|disciplinasOfTurma,' + idTurma
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/turma/frequencias/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            // Html de disciplinas
            var htmlDisciplina = "<option value=''>Selecione uma Disciplina</option>";

            // Percorrendo o array de disciplina
            for(var i = 0; i < retorno['graduacao\\disciplina'].length; i++) {
                // Criando as options
                htmlDisciplina += "<option value='" + retorno['graduacao\\disciplina'][i].id + "'>"  + retorno['graduacao\\disciplina'][i].nome + "</option>";
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