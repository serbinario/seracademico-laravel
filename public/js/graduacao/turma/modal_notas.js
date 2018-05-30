// Evento para fechar modal
$(document).on('click', '#btnCloseModalNotas', function () {
    $('#disciplinaSearch option').remove();
});

$(document).on('change', '#disciplinaSearch', function (event) {
    idDisciplina = $(this).val();
    loadFieldsNotas(idTurma, idDisciplina);
});


$(document).on( 'focusout', 'td', function( event ) {

    var idAlunoNota = $(this).parent()[0].id
    var valor = $(this)[0].firstChild.value
    var coluna = $(this).attr("class")
    console.log( 'id Registro: ' +  idAlunoNota + ' Valor: ' + valor + ' Coluna: ' + coluna );

    // Definindo os models
    var dados =  {
        'valor' : valor,
        'coluna' : coluna
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        data: dados,
        contentType: "application/json; charset=utf-8",
        url: '/index.php/seracademico/graduacao/turma/notas/update/' + idAlunoNota,
        //TurmaNotaController
        datatype: 'json'
    }).done(function (retorno) {

    });
});

// Função para carregar a grid
var tableNotas;



function runTableNotas(idTurma) {
   // if (tableNotas) {
        //tableNotas.ajax.url( "/index.php/seracademico/graduacao/turma/notas/grid/" + idTurma).load();
   // } else {
        // Carregamento da grids
        //loadTableNotas(idTurma);
    //}
    //Carrega as disiciplinas
    loadFieldsDisciplinas();

    // Carregamento os campos necessários
    //loadFieldsNotas(idTurma);



    // Configurações do modal
    $("#modal_notas_new").modal({show: true, keyboard: true});
}

// carregando todos as Disciplinas 
function loadFieldsDisciplinas()
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
        //TurmaNotaController
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

function loadFieldsNotas(idTurma, idDisciplina) {

    //Arquivo: TurmaNotaController  metodo: notasDaTurma
    //$.ajax({url: "/index.php/seracademico/graduacao/turma/notas/notasDaTurma/" + idTurma + idDisciplina;

    var fieldsSearch =  {
        'idDisciplina' : idDisciplina

    };
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        data: fieldsSearch,
        contentType: "application/json; charset=utf-8",
        url: '/index.php/seracademico/graduacao/turma/notas/notasDaTurma/' + idTurma,
        //TurmaNotaController
        datatype: 'json'
    }).done(function(result){
        var htmlNotas = '';

        htmlNotas += '<tbody>'
        // Percorrendo o array de disciplina
        for(var i = 0; i < result.notas.length; i++) {
            // Criando as options
            htmlNotas += '<tr id=\"' +result.notas[i].idAlunoNota  +'">'
                +'<td>'+result.notas[i].nomePessoa+'</td>'
                +'<td class="nota_unidade_1"><input style="width: 100%" value=\"'+result.notas[i].nota_unidade_1+'\"></td>'
                +'<td class="nota_unidade_2"><input style="width: 100%" value=\"'+result.notas[i].nota_unidade_2+'\"></td>'
                +'<td class="nota_2_chamada"><input style="width: 100%" value=\"'+result.notas[i].nota_2_chamada+'\"></td>'
                +'<td class="nota_final"><input  style="width: 100%" value=\"'+result.notas[i].nota_final+'\"></td>'
                +'<td>'+result.notas[i].nota_media+'</td>'
                +'<td>'+result.notas[i].total_falta+'</td>'
                +'<td>'+result.notas[i].nomeSituacao+'</td>'
                +'</tr>';
        }
        htmlNotas += '</tbody>';

        // Remove toda a tbody
        $("#notas-grid tbody").remove();

        $("#notas-grid").append(htmlNotas);


    });
}