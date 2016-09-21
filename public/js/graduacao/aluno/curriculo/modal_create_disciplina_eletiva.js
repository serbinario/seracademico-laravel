// id da disciplina eletiva do currículo principal
var idDisciplinaEletiva, idTurmaDisciplinaEletiva;

// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnAttachEletiva", function () {
    // recuperando o id da disciplina e turma
    idDisciplinaEletiva = tableEletiva.row($(this).parents('tr')).data().id;

    // carregando o formulário
    loadFieldsAttachEletiva();
});

// carregando todos os campos preenchidos
function loadFieldsAttachEletiva()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Disciplina|eletiva,' + idAluno
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/aluno/curriculo/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsAttachEletiva(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-disciplina-eletiva').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsAttachEletiva (dados) {
    //Limpando os campos
    $('#turma_disciplina_id option').find('option').prop('selected', false);

    // Variáveis que armazenaram o html
    var htmlDisciplina  = "<option value=''>Selecione uma disciplina</option>";

    // Percorrendo o array de disciplina
    for (var i = 0; i < dados['graduacao\\disciplina'].length; i++) {
        htmlDisciplina += "<option value='" + dados['graduacao\\disciplina'][i].id + "'>" + dados['graduacao\\disciplina'][i].nome + "</option>";
    }

    // carregando o html
    $("#turma_disciplina_id option").remove();
    $("#turma_disciplina_id").append(htmlDisciplina);

    // Abrindo o modal de inserir disciplina extra curricular do aluno
    $("#modal-create-disciplina-eletiva").modal({show : true});
}

// Evento para salvar tabela de disciplinas extras curriculares dos alunos
$('#btnSaveDisciplinaEletiva').click(function() {
    // Recuperando os valores do formulário
    var turma_disciplina_id  = $("#turma_disciplina_id option:selected").val();

    // Validando os dados de entrada
    if(!turma_disciplina_id) {
        swal('Ocorreu um erro', 'Você deve informar a disciplina', 'error');
        return false;
    }

    // Dados de envio
    var dados = {
        'turma_disciplina_id' : turma_disciplina_id,
        'disciplina_id' : idDisciplinaEletiva,
        'aluno_id' : idAluno,
        'semestre_id' : idSemestre,
        'turma_id' : idTurmaDisciplinaEletiva
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/curriculo/storeDisciplinaEletiva',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableACursar.ajax.reload();
            tableEletiva.ajax.reload();

            // fechando a modal
            $('#modal-create-disciplina-eletiva').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});


// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDetachEletiva', function () {
    var id = tableEletiva.row($(this).parent().parent().index()).data().idEletiva;

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/aluno/curriculo/deleteDisciplinaEletiva/' + id,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableEletiva.ajax.reload();
            tableACursar.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});