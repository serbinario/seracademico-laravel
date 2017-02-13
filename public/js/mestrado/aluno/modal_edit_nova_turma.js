// Variável que armazenará o id vinculo do aluno com a turma
var posAlunoTurmaId;

// Evento para editar a tabela de preços
$(document).on('click', '#btnEditAlunoCurso', function () {
    //Recuperando o id da dispensa
    posAlunoTurmaId = tableCursoTurma.row($(this).parents('tr')).data().id;

    //carregando o formulário
    loadFieldsNovaTurmaEditar();
});

// carregando todos os campos preenchidos
function loadFieldsNovaTurmaEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'SituacaoAluno',
            'Professor',
            'Instituicao'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/mestrado/aluno/turma/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsNovaTurmaEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-edit-nova-turma-aluno').modal('toggle');
        }
    });
};

// Limpa os valores dos campos
function clearValueFieldsEdit()
{
    // Iniciais
    $("#curso_edit").find("option:selected").removeAttr("selected");
    $("#turma_id_edit option").remove();
    $("#situacao_id_edit").find("option:selected").removeAttr("selected");

    // Monografia / Gerais
    $("#titulo_edit").val("");
    $("#nota_final_edit").val("");
    $("#madia_edit").val("");
    $("#media_conceito_edit").val("");
    $("#defendeu_edit").val("");
    $("#professor_orientador_id_edit").find("option:selected").removeAttr("selected");
    $("#defesa_edit").val("");

    // Monografia / Banca examinadora
    $("#professor_banca_1_id_edit").find("option:selected").removeAttr("selected");
    $("#professor_banca_2_id_edit").find("option:selected").removeAttr("selected");
    $("#professor_banca_3_id_edit").find("option:selected").removeAttr("selected");
    $("#professor_banca_4_id_edit").find("option:selected").removeAttr("selected");
    $("#inst_ensino_banca_1_id_edit").find("option:selected").removeAttr("selected");
    $("#inst_ensino_banca_2_id_edit").find("option:selected").removeAttr("selected");
    $("#inst_ensino_banca_3_id_edit").find("option:selected").removeAttr("selected");
    $("#inst_ensino_banca_4_id_edit").find("option:selected").removeAttr("selected");

    // Formatura
    $("#data_conclusao_edit").val("");
    $("#data_colacao_edit").val("");
}

// Função a montar o html
function builderHtmlFieldsNovaTurmaEditar (dados) {
    // limpando os campos
    clearValueFieldsEdit();

    //Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/mestrado/aluno/turma/edit/' + posAlunoTurmaId,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Variáveis que armazenaram o html
            var htmlSituacao    = "<option value=''>Selecione uma situação</option>";
            var htmlProfessor   = "<option value=''>Selecione um professor</option>";
            var htmlInstituicao = "<option value=''>Selecione uma instituição</option>";


            // Percorrendo o array de situacaoaluno
            for(var i = 0; i < dados['situacaoaluno'].length; i++) {
                // Criando as options
                htmlSituacao += "<option value='" + dados['situacaoaluno'][i].id + "'>"  + dados['situacaoaluno'][i].nome + "</option>";
            }

            // Percorrendo o array de professor
            for(var i = 0; i < dados['professor'].length; i++) {
                // Criando as options
                htmlProfessor += "<option value='" + dados['professor'][i].id + "'>"  + dados['professor'][i].nome + "</option>";
            }

            // Removendo e adicionando as options de situacao aluno
            $("#situacao_id_edit option").remove();
            $("#situacao_id_edit").append(htmlSituacao);

            // Removendo e adicionando as options de Professor orientador
            $("#professor_orientador_id_edit option").remove();
            $("#professor_orientador_id_edit").append(htmlProfessor);

            // Carregando o curso escolhido
            $('#curso_edit').html('<option value="' + retorno.dados.curso.id  +'">'+ retorno.dados.curso.nome +'</option>');

            // Carregando as turmas
            loadTurmasAlunoEditar(retorno.dados.curso.id, retorno.dados.turma.id);

            // Carregando a situação
            $('#situacao_id_edit option[value=' + retorno.dados.situacao.id + ']').attr('selected', true);

            // Carregando os demais campos
            $('#media_editar').val(retorno.dados.media);
            $('#carga_horaria_editar').val(retorno.dados.carga_horaria);
            $('#qtd_credito_editar').val(retorno.dados.qtd_credito);
            $('#data_editar').val(retorno.dados.data);

            // Exibindo a modal
            $('#modal-edit-nova-turma-aluno').modal({show: true, keyboard: true});
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}


// Função para carregar as turmas vincularas a curriculo
function loadTurmasAlunoEditar(idCurriculo, idTurma)
{
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/mestrado/aluno/turma/getTurmas/' + idCurriculo,
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            // Variável que armazenará o html
            var html = "<option value=''>Selecione uma turma</option>";

            // Percorrendo o array
            for(var i = 0; i < retorno.length; i++) {
                if(retorno[i].id == idTurma) {
                    // Criando as options
                    html += "<option selected value='" + retorno[i].id + "'>"  + retorno[i].codigo + "</option>";
                } else {
                    // Criando as options
                    html += "<option value='" + retorno[i].id + "'>"  + retorno[i].codigo + "</option>";
                }
            }

            // Removendo e adicionando as options
            $("#turma_id_edit option").remove();
            $("#turma_id_edit").append(html);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-edit-nova-turma-aluno').modal('toggle');
        }
    });
}

// Recuperando os valores dos campos
function getValueFieldsEditar()
{
    // Iniciais
    var curriculo_id            = $("#curso_edit").val();
    var turma_id                = $("#turma_id_edit").val();
    var situacao_id             = $("#situacao_id_edit").val();

    // Monografia / Gerais
    var titulo                  = $("#titulo_edit").val();
    var nota_final              = $("#nota_final_edit").val();
    var madia                   = $("#madia_edit").val();
    var media_conceito          = $("#media_conceito_edit").val();
    var defendeu                = $("#defendeu_edit").val();
    var professor_orientador_id = $("#professor_orientador_id_edit").val();
    var defesa                  = $("#defesa_edit").val();

    // Monografia / Banca examinadora
    var professor_banca_1_id    = $("#professor_banca_1_id_edit").val();
    var professor_banca_2_id    = $("#professor_banca_2_id_edit").val();
    var professor_banca_3_id    = $("#professor_banca_3_id_edit").val();
    var professor_banca_4_id    = $("#professor_banca_4_id_edit").val();
    var inst_ensino_banca_1_id  = $("#inst_ensino_banca_1_id_edit").val();
    var inst_ensino_banca_2_id  = $("#inst_ensino_banca_2_id_edit").val();
    var inst_ensino_banca_3_id  = $("#inst_ensino_banca_3_id_edit").val();
    var inst_ensino_banca_4_id  = $("#inst_ensino_banca_4_id_edit").val();

    // Formatura
    var data_conclusao          = $("#data_conclusao_edit").val();
    var data_colacao            = $("#data_colacao_edit").val();

    // Preparando os dados
    var dados = {
        'curriculo_id'            : curriculo_id,
        'aluno_id'                : idAluno,
        'turma_id'                : turma_id == "" ? null : turma_id,
        'situacao_id'             : situacao_id == "" ? null : situacao_id,
        'titulo'                  : titulo,
        'nota_final'              : nota_final,
        'madia'                   : madia,
        'media_conceito'          : media_conceito,
        'defendeu'                : defendeu,
        'professor_orientador_id' : professor_orientador_id == "" ? null : professor_orientador_id,
        'defesa'                  : defesa,
        'professor_banca_1_id'    : professor_banca_1_id == "" ? null : professor_banca_1_id,
        'professor_banca_2_id'    : professor_banca_2_id == "" ? null : professor_banca_2_id,
        'professor_banca_3_id'    : professor_banca_3_id == "" ? null : professor_banca_3_id,
        'professor_banca_4_id'    : professor_banca_4_id == "" ? null : professor_banca_4_id,
        'inst_ensino_banca_1_id'  : inst_ensino_banca_1_id == "" ? null : inst_ensino_banca_1_id,
        'inst_ensino_banca_2_id'  : inst_ensino_banca_2_id == "" ? null : inst_ensino_banca_2_id,
        'inst_ensino_banca_3_id'  : inst_ensino_banca_3_id == "" ? null : inst_ensino_banca_3_id,
        'inst_ensino_banca_4_id'  : inst_ensino_banca_4_id == "" ? null : inst_ensino_banca_4_id,
        'data_conclusao'          : data_conclusao,
        'data_colacao'            : data_colacao
    };

    // Retorno
    return dados;
}

// Evento para update tabela de preços
$('#btnUpdateTurmaAluno').click(function() {
    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/mestrado/aluno/turma/update/' + posAlunoTurmaId,
        data: getValueFieldsEditar(),
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableCursoTurma.ajax.reload();

            $('#modal-edit-nova-turma-aluno').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

