// Evento para o click do botão de "novo" dispensar disciplina
$(document).on('click', '#btnNewDispensarDisciplina', function () {
    loadFieldsDispensarDisciplina();
});

// carregando todos os campos preenchidos
function loadFieldsDispensarDisciplina()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Disciplina|curriculoByAluno,' + idAluno,
            'Instituicao|byNivel,3',
            'Graduacao\\Motivo'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/aluno/curriculo/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {// validado as disciplinas do currículo
        // Verificando o retorno da requisição
        if(retorno['graduacao\\disciplina'].length > 0) {
            builderHtmlFieldsDispensarDisciplina(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal("Desculpe não existe disciplinas disponíveis", "Click no botão abaixo!", "error");
            $('#modal-inserir-dispensar-disciplina').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDispensarDisciplina (dados) {
    // limpando os campos
    $("#motivo_id").find("option").eq(0).prop("selected", true);
    $("#disciplina_id").find("option").eq(0).prop("selected", true);
    $("#insituicao_id").find("option").eq(0).prop("selected", true);
    $("#media").val("");
    $("#carga_horaria").val("");
    $("#qtd_credito").val("");
    $("#data").val("");

    // Declaradno as variávies html
    $htmlDisciplina  = '<option value="">Selecione uma disciplina</option>';
    $htmlInstituicao = '<option value="">Selecione um motivo</option>';
    $htmlMotivo      = '<option value="">Selecione um motivo</option>';

    // Preenchendo as disciplinas
    $.each(dados['graduacao\\disciplina'], function (index, value) {
        $htmlDisciplina += '<option value="' + value.id + '">' + value.nome + '</option>';
    });

    // Preenchendo os motivos
    $.each(dados['instituicao'], function (index, value) {
        $htmlInstituicao += '<option value="' + value.id + '">' + value.nome + '</option>';
    });

    // Preenchendo os motivos
    $.each(dados['graduacao\\motivo'], function (index, value) {
        $htmlMotivo += '<option value="' + value.id + '">' + value.nome + '</option>';
    });

    // carregando os selects
    $('#disciplina_id option').remove();
    $('#disciplina_id').append($htmlDisciplina);
    $('#instituicao_id option').remove();
    $('#instituicao_id').append($htmlInstituicao);
    $('#motivo_id option').remove();
    $('#motivo_id').append($htmlMotivo);

    // Abrindo o modal de inserir disciplina
    $('#modal-inserir-dispensar-disciplina').modal({'show': true});
}

// Evento para salvar tabela de preços
$('#btnSalvarDispensarDisciplina').click(function() {
    // Recuperando os parametros
    var disciplina_id  = $("#disciplina_id option:selected").val();
    var instituicao_id = $("#instituicao_id option:selected").val();
    var motivo_id      = $("#motivo_id option:selected").val();
    var carga_horaria  = $("#carga_horaria").val();
    var media          = $("#media").val();
    var qtd_credito    = $("#qtd_credito").val();
    var data           = $("#data").val();

    // Dados de para cadastro da disciplina
    var dados = {
        'semestre_id'    : idSemestre,
        'aluno_id'       : idAluno,
        'disciplina_id'  : disciplina_id,
        'instituicao_id' : instituicao_id,
        'motivo_id'      : motivo_id,
        'carga_horaria'  : carga_horaria,
        'media'          : media,
        'qtd_credito'    : qtd_credito,
        'data'           : data
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/graduacao/aluno/curriculo/storeDispensada',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDispensadas.ajax.reload();
            tableACursar.ajax.reload();

            $('#modal-inserir-adicionar-disciplina').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDeleteDispensada', function () {
    var idDispensada = tableDispensadas.row($(this).parent().parent().index()).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/aluno/curriculo/deleteDispensada/' + idDispensada,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDispensadas.ajax.reload();
            tableACursar.ajax.reload();
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});
