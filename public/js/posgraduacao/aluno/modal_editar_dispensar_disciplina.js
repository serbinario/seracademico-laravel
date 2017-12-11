// Id da dispensa
var idAlunoDisciplinaDispensada;

// Evento para editar a tabela de preços
$(document).on('click', '#btnEditDisciplinaDispensada', function () {
    //Recuperando o id da dispensa
    idAlunoDisciplinaDispensada = tableDisciplinasDispensadas.row($(this).parent().parent().index()).data().id;

    //carregando o formulário
    loadFieldsDispensarDisciplinaEditar();
});

// carregando todos os campos preenchidos
function loadFieldsDispensarDisciplinaEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'PosGraduacao\\Disciplina|curriculoByAluno,' + idAluno,
            'PosGraduacao\\Curriculo|byAluno,' + idAluno,
            'Instituicao|byNivel,3',
            'Graduacao\\Motivo'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/posgraduacao/aluno/turma/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {// validado as disciplinas do currículo
        // Verificando o retorno da requisição
        if(retorno['posgraduacao\\disciplina'].length > 0) {
            builderHtmlFieldsDispensarDisciplinaEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal("Desculpe não existe disciplinas disponíveis", "Click no botão abaixo!", "error");
            $('#modal-editar-dispensar-disciplina').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDispensarDisciplinaEditar (dados) {
    // limpando os campos
    $("#motivo_id_editar").find("option").eq(0).prop("selected", true);
    $("#disciplina_id_editar").find("option").eq(0).prop("selected", true);
    $("#insituicao_id_editar").find("option").eq(0).prop("selected", true);
    $("#disciplina_origem_id_editar option").remove();
    $("#media_editar").val("");
    $("#carga_horaria_editar").val("");
    $("#qtd_credito_editar").val("");
    $("#data_editar").val("");

    //Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/aluno/curriculo/editDispensada/' + idAlunoDisciplinaDispensada,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Declaradno as variávies html
            $htmlDisciplina  = '<option value="">Selecione uma disciplina</option>';
            $htmlCurriculo  = '<option value="">Selecione um currículo de origem</option>';
            $htmlInstituicao = '<option value="">Selecione um motivo</option>';
            $htmlMotivo      = '<option value="">Selecione um motivo</option>';

            // Preenchendo as disciplinas
            $.each(dados['posgraduacao\\disciplina'], function (index, value) {
                $htmlDisciplina += '<option value="' + value.id + '">' + value.nome + '</option>';
            });

            // Preenchendo os curriculos
            $.each(dados['posgraduacao\\curriculo'], function (index, value) {
                $htmlCurriculo += '<option value="' + value.id + '">' + value.nome + '</option>';
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
            $('#disciplina_id_editar option').remove();
            $('#disciplina_id_editar').append($htmlDisciplina);
            $('#curriculo_origem_id_editar option').remove();
            $('#curriculo_origem_id_editar').append($htmlCurriculo);
            $('#instituicao_id_editar option').remove();
            $('#instituicao_id_editar').append($htmlInstituicao);
            $('#motivo_id_editar option').remove();
            $('#motivo_id_editar').append($htmlMotivo);

            // Preechendo os campos do formulário
            $('select#disciplina_id_editar option[value="' + retorno.dados.disciplina_id+ '"]').prop('selected', true);
            $('select#instituicao_id_editar option[value="' + retorno.dados.instituicao_id + '"]').prop('selected', true);
            $('select#motivo_id_editar option[value="' + retorno.dados.motivo_id + '"]').prop('selected', true);
            $('#media_editar').val(retorno.dados.nota_final);
            $('#carga_horaria_editar').val(retorno.dados.carga_horaria);
            $('#qtd_credito_editar').val(retorno.dados.qtd_credito);
            $('#data_editar').val(retorno.dados.data);

            // Exibindo a modal
            $('#modal-editar-dispensar-disciplina').modal({show: true, keyboard: true});
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para update tabela de preços
$('#btnUpdateDispensarDisciplina').click(function() {
    // Recuperando os parametros
    var disciplina_id  = $("#disciplina_id_editar option:selected").val();
    var instituicao_id = $("#instituicao_id_editar option:selected").val();
    var motivo_id      = $("#motivo_id_editar option:selected").val();
    var carga_horaria  = $("#carga_horaria_editar").val();
    var nota_final     = $("#media_editar").val();
    var qtd_credito    = $("#qtd_credito_editar").val();
    var data           = $("#data_editar").val();

    // Dados de para cadastro da disciplina
    var dados = {
        'disciplina_id'  : disciplina_id,
        'instituicao_id' : instituicao_id,
        'motivo_id'      : motivo_id,
        'carga_horaria'  : carga_horaria,
        'nota_final'     : nota_final,
        'qtd_credito'    : qtd_credito,
        'data'           : data
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/posgraduacao/aluno/curriculo/updateDispensada/' + idAlunoDisciplinaDispensada,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDisciplinasDispensadas.ajax.reload();
            tableDisciplinasACursar.ajax.reload();

            $('#modal-editar-dispensar-disciplina').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});


$(document).on('change', '#curriculo_origem_id_editar', function () {
    var curriculo_id = $(this).val();

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/aluno/curriculo/getDisciplinasByCurriculoWithNota/' + idAluno + '/' + curriculo_id,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            $htmlDisciplina   = '<option value="">Escolha uma disciplina</option>';

            // Preenchendo as disciplinas
            $.each(retorno.dados, function (index, value) {
                $htmlDisciplina += '<option value="' + value.id + '">' + value.nome + '</option>';
            });

            $('#disciplina_origem_id_editar option').remove();
            $('#disciplina_origem_id_editar').append($htmlDisciplina);
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

$(document).on('change', '#disciplina_origem_id_editar', function () {
    var disciplina_origem_id = $(this).val();
    var curriculo_origem_id = $('#curriculo_origem_id_editar option:selected').val();

    var dados = {
        'disciplina_id' : disciplina_origem_id,
        'curriculo_id' : curriculo_origem_id,
        'aluno_id' : idAluno
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/aluno/curriculo/getNota',
        datatype: 'json',
        data: dados
    }).done(function (retorno) {
        if(retorno.dados) {
            $('#media_editar').val(retorno.dados.nota_final);
        } else if (retorno.error)  {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        } else {
            swal('Não existe nota para essa disciplina', "Click no botão abaixo!", "error");
        }
    });
});