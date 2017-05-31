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
            url: "/index.php/seracademico/tecnico/turma/notas/grid/" + idTurma,
            data: function (d) {
                d.disciplina = $('select[name=disciplinaSearch] option:selected').val();
            }
        },
        columns: [
            {data: 'nomePessoa', name: 'pessoas.nome'},
            // {data: 'nota_final', name: 'fac_alunos_notas.nota_final'},
            {data: 'nome_disciplina', name: 'fac_disciplinas.nome'},
            {data: 'situacao', name: 'fac_situacao_nota.nome'},
            {data: 'status', name: 'status', orderable: false, filterable: false},
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
        tableNotas.ajax.url( "/index.php/seracademico/tecnico/turma/notas/grid/" + idTurma).load();
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
            'Tecnico\\Disciplina|disciplinasOfTurma,' + idTurma
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/tecnico/turma/notas/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            // Html de disciplinas
            var htmlDisciplina = "<option value=''>Selecione uma Disciplina</option>";

            // Percorrendo o array de disciplina
            for(var i = 0; i < retorno['tecnico\\disciplina'].length; i++) {
                // Criando as options
                htmlDisciplina += "<option value='" + retorno['tecnico\\disciplina'][i].id + "'>"  + retorno['tecnico\\disciplina'][i].nome + "</option>";
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

// Evento para alterar a nota
$(document).on('focusout', '.nota_final', function () {
    // Recuperando a nota informada
    var nota_final = $(this).val();

    // Validando a nota
    if(!(typeof parseFloat(nota_final) == 'number')) {
        swal('Valor informado é inválido', '', 'error');
        return false;
    }

    // Recuperando o id da nota do aluno
    var idALunoNota = tableNotas.row($(this).parents('tr')).data().idAlunoNota;

    // Dados da requisição
    var dados = {
        'nota_final' : nota_final,
        'situacao_nota_id' : 1
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/tecnico/turma/notas/update/' + idALunoNota,
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno.success) {
            $('#span_nota_' + retorno.dados.id + ' i').remove()
            $('#span_nota_' + retorno.dados.id).append('<i class="material-icons">done</i>');
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});