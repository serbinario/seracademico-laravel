// Evento para fechar modal
$(document).on('click', '#btnCloseModalNotas', function () {
    $('#disciplinaSearch option').remove();
});

// Função para carregar a grid
var tableNotas;
function loadTableNotas (idTurma) {
    tableNotas = $('#alunos-notas-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: {
            url: "/index.php/seracademico/graduacao/turma/notas/grid/" + idTurma,
            data: function (d) {
                d.disciplina = $('select[name=disciplinaSearch] option:selected').val();
            }
        },
        columns: [
            {data: 'nomePessoa', name: 'pessoas.nome'},
            {data: 'nota_unidade_1', name: 'fac_alunos_notas.nota_unidade_1'},
            {data: 'nota_unidade_2', name: 'fac_alunos_notas.nota_unidade_2'},
            {data: 'nota_2_chamada', name: 'fac_alunos_notas.nota_2_chamada'},
            {data: 'nota_final', name: 'fac_alunos_notas.nota_final'},
            {data: 'nota_media', name: 'fac_alunos_notas.nota_media'},
            {data: 'total_falta', name: 'fac_alunos_frequencias.total_falta'},
            {data: 'nomeSituacao', name: 'fac_situacao_nota.nome'},
            {data: 'action', name: 'action'}
        ]
    });

    // Função do submit do search da grid principal
    $('#search-form').on('submit', function(e) {
        tableNotas.draw();
        e.preventDefault();
    });

    // retorno
    return tableNotas;
}

// Função para executar a grid
function runTableNotas(idTurma) {
    if (tableNotas) {
        tableNotas.ajax.url( "/index.php/seracademico/graduacao/turma/notas/grid/" + idTurma).load();
    } else {
        // Carregamento da grids
        loadTableNotas(idTurma);
    }

    // Carregamento os campos necessários
    loadFieldsNotas();

        
    // Configurações do modal
    $("#modal-notas-alunos").find('.modal-dialog').css("width", "97%");
    $("#modal-notas-alunos").find('.modal-dialog').css("max-height", "97%");
    $("#modal-notas-alunos").modal({show: true, keyboard: true});
}

// carregando todos os campos preenchidos
function loadFieldsNotas()
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
        url: '/index.php/seracademico/graduacao/turma/notas/getLoadFields',
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
            $("#disciplinaSearch option").remove();
            $("#disciplinaSearch").append(htmlDisciplina);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-alunos-notas').modal('toggle');
        }
    });
};