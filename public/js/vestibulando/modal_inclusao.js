
// Evento para chamar o modal de inserir adicionar disciplina
function runInclusao() {
    loadFieldsEditar();
}

// carregando todos os campos preenchidos
function loadFieldsEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Graduacao\\Curso|byVestibulando,' + idVestibulando,
            'FormaAdmissao|byId,1',
            'Graduacao\\Semestre'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/vestibulando/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {// validado as disciplinas do currículo
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-inclusao').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsEditar (dados) {
    //Limpando os campos
    $('#curso_id option').attr('selected', false);
    $('#forma_admissao_id option').attr('selected', false);
    $('#turno_id option').attr('selected', false);
    $('#data_inclusao').val('');

    // Fazendo a requisição para recuperar os dados do curriculoDisciplina
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibulando/inclusao/edit/' + idVestibulando,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            // Variáveis que armazenaram o html
            var htmlCurso     = "";
            var htmlFAdmissao = "";
            var htmlSemestre  = "";

            // Percorrendo o array de cursos
            for (var i = 0; i < dados['graduacao\\curso'].length; i++) {
                htmlCurso += "<option value='" + dados['graduacao\\curso'][i].id + "'>" + dados['graduacao\\curso'][i].nome + "</option>";

            }

            // Percorrendo o array de formas de admissoes
            for (var i = 0; i < dados['formaadmissao'].length; i++) {
                htmlFAdmissao += "<option value='" + dados['formaadmissao'][i].id + "'>" + dados['formaadmissao'][i].nome + "</option>";

            }

            // Percorrendo o array de semestres
            for (var i = 0; i < dados['graduacao\\semestre'].length; i++) {
                htmlSemestre += "<option value='" + dados['graduacao\\semestre'][i].id + "'>" + dados['graduacao\\semestre'][i].nome + "</option>";

            }

            $("#curso_id option").remove();
            $("#curso_id").append(htmlCurso);

            $("#forma_admissao_id option").remove();
            $("#forma_admissao_id").append(htmlFAdmissao);

            $("#semestre_id option").remove();
            $("#semestre_id").append(htmlSemestre);

            // Verificando se a transferência já foi realizada
            if (retorno.dados.curso_id) {
                // Setando os valores do model no formulário
                $('#curso_id option[value=' + retorno.dados.curso_id + ']').attr('selected', true).parent().prop('disabled', true);
                $('#forma_admissao_id option[value=' + retorno.dados.forma_admissao_id + ']').attr('selected', true);
                $('#turno_id').html('<option value="' + retorno.dados.turno_id + '">' + retorno.dados.nomeTurno + '</option>');
                $('#semestre_id option[value=' + retorno.dados.semestre_id + ']').attr('selected', true);
                $('#data_inclusao').val(retorno.dados.data_inclusao);

                //$('#turno_id option[value=' + retorno.dados.turno_id + ']').attr('selected', true);
                //$('#periodo').val(retorno.dados.periodo);
            } else {
                // Habilitando a o campo de curso
                $('#curso_id').prop('disabled', false);

                // Recuperando o id do curso selecionado
                var cursoId = $("#curso_id").find("option:selected").val();

                // carregando os campos
                getTurnosByCurso(idVestibular ,cursoId, '#turno_id');
            }


            // Abrindo o modal de inserir disciplina
            $("#modal-inclusao").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdateInclusao').click(function() {
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
        url: '/index.php/seracademico/vestibulando/inclusao/update/' + idVestibulando,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            table.ajax.reload();
            $('#modal-inclusao').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

/**
 *
 * Evento para recuperar as opções de turno do curso
 */
$(document).on('change', '#curso_id', function () {
    // Recuperando o id do curso
    var idCurso = $(this).find('option:selected').val();

    // verificando se o curso foi selecionado
    if(idCurso) {
        // Gerando os options
        getTurnosByCurso(idVestibular, idCurso, '#turno_id');
    }
});


/**
 *
 * Método que recupera os turnos correspondentes
 * e carrega os selects no formulário
 *
 * @param idCurso
 * @param idHtml
 */
function getTurnosByCurso (idVestibular, idCurso, idHtml) {
    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/vestibular/curso/turno/getTurnosByCurso',
        headers: {
        'X-CSRF-TOKEN': '{{  csrf_token() }}'
    },
    data: {'idCurso' : idCurso, 'idVestibular' : idVestibular},
    datatype: 'json'
}).done(function (json) {
        // Variável que armazenará o html
        var options = '';

        // Criando os options
        options += '<option value="">Selecione um Turno</option>';
        for (var i = 0; i < json.data.length; i++) {
            options += '<option value="' + json.data[i]['id'] + '">' + json.data[i]['nome'] + '</option>';
        }

        // Gerando o html
        $(idHtml).find('option').remove();
        $(idHtml).append(options);
    });
}