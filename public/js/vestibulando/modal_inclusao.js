
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
            'Graduacao\\Curso|byCurriculoAtivo,1',
            'Turno',
            'FormaAdmissao',
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
            var htmlTurno     = "";
            var htmlFAdmissao = "";
            var htmlSemestre  = "";

            // Percorrendo o array de cursos
            for (var i = 0; i < dados['graduacao\\curso'].length; i++) {
                htmlCurso += "<option value='" + dados['graduacao\\curso'][i].id + "'>" + dados['graduacao\\curso'][i].nome + "</option>";

            }

            // Percorrendo o array de turnos
            for (var i = 0; i < dados['turno'].length; i++) {
                htmlTurno += "<option value='" + dados['turno'][i].id + "'>" + dados['turno'][i].nome + "</option>";

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

            $("#turno_id option").remove();
            $("#turno_id").append(htmlTurno);

            $("#forma_admissao_id option").remove();
            $("#forma_admissao_id").append(htmlFAdmissao);

            $("#semestre_id option").remove();
            $("#semestre_id").append(htmlSemestre);


            // Setando os valores do model no formulário
            $('#curso_id option[value=' + retorno.dados.curso_id + ']').attr('selected', true);
            $('#forma_admissao_id option[value=' + retorno.dados.forma_admissao_id + ']').attr('selected', true);
            $('#turno_id option[value=' + retorno.dados.turno_id + ']').attr('selected', true);
            $('#semestre_id option[value=' + retorno.dados.semestre_id + ']').attr('selected', true);
            $('#data_inclusao').val(retorno.dados.data_inclusao);
            $('#periodo').val(retorno.dados.periodo);

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
            $('#modal-inclusao').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});