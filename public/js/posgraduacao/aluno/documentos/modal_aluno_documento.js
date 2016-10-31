// carregando todos os campos preenchidos
function loadFieldsDocumentos()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'PosGraduacao\\TipoDocumento'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/SerAcademmico/public/index.php/seracademico/posgraduacao/aluno/turma/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsDocumento(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-aluno-documento').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDocumento (dados) {
    //Limpando os campos
    $('#documentacao_id option').attr('selected', false);

console.log(dados);
    // Variáveis que armazenaram o html
    var htmlDocumento     = "";

    // Percorrendo o array de cursos
    for (var i = 0; i < dados['posgraduacao\\tipodocumento'].length; i++) {
        htmlDocumento += "<option value='" + dados['posgraduacao\\tipodocumento'][i].id + "'>" + dados['posgraduacao\\tipodocumento'][i].nome + "</option>";
    }

    $("#documentacao_id option").remove();
    $("#documentacao_id").append(htmlDocumento);

    // Abrindo o modal de inserir disciplina
    $("#modal-aluno-documento").modal({show : true});
}

// Evento para salvar histórico
$('#btnSaveHistorico').click(function() {
    var curso_id  = $("#curso_id").val();
    var turno_id  = $("#turno_id").val();
    var forma_admissao_id = $("#forma_admissao_id").val();
    var data_inclusao = $("#data_inclusao").val();
    var semestre_id   = $("#semestre_id").val();
    var periodo       = $("#periodo").val();

    var dados = {
        'periodo' : periodo,
        'semestre_id' : semestre_id,
        'curso_id': curso_id,
        'turno_id': turno_id,
        'forma_admissao_id' : forma_admissao_id,
        'data_inclusao' : data_inclusao,
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/historico/save/' + idAluno,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            table.ajax.reload();
            tableHistorico.ajax.reload();
            // tableHistorico.ajax.reload(function () {
            //     tablePrecosCurso.row(indexRowSelectedPrecoCurso).nodes().to$().find('td').addClass("row_selected");
            // });
            $('#modal-create-historico').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDeleteHistorico', function () {
    // recuperando o id do aluno_semestre
    var idAlunoSemestre = tableHistorico.row($(this).parent().parent().index()).data().idAlunoSemestre;

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/historico/delete/' + idAlunoSemestre,
        datatype: 'json'
    }).done(function (retorno) {
        table.ajax.reload();
        tableHistorico.ajax.reload();
        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});