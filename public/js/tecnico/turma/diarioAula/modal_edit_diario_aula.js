// Id do benefício e table
var idDiarioAula;

// Evento para chamar o modal de inserir adicionar disciplina
$(document).on("click", "#btnEditDiarioAula", function () {
    idDiarioAula = tableDiarioAula.row($(this).parents('tr')).data().id;
    loadFieldsDiarioAulaEditar();

    // Carregando a grid de conteúdos programáticos
    if(tableConteudoProgramaticoDiarioAulaEdit) {
        loadTableConteudoProgramaticoDiarioAulaEdit().ajax.url("/index.php/seracademico/tecnico/turma/diarioAula/gridConteudoProgramatico/" + idDiarioAula).load();
    } else {
        loadTableConteudoProgramaticoDiarioAulaEdit();
    }
});

// carregando todos os campos preenchidos
function loadFieldsDiarioAulaEditar()
{
    // Definindo os models
    var dados =  {
        'models' : [
            'Professor|getValues'
        ]
    };

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        data: dados,
        url: '/index.php/seracademico/tecnico/turma/diarioAula/getLoadFields',
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno) {
            builderHtmlFieldsDiarioAulaEditar(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-edit-diario-aula').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDiarioAulaEditar (dados) {
    // Fazendo a requisição para recuperar os dados do curriculoDisciplina
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/tecnico/turma/diarioAula/edit/' + idDiarioAula,
        datatype: 'json'
    }).done(function (retorno) {
        if (retorno.success) {
            //Limpando os campos
            $("#conteudo_programatico_diario_aula_edit").select2("val", "");


            // Variáveis que armazenaram o html
            var htmlProfessor = "<option value=''>Selecione um Professor</option>";

            // Percorrendo o array de tipos valores
            for (var i = 0; i < dados['professor'].length; i++) {
                htmlProfessor += "<option value='" + dados['professor'][i].id + "'>" + dados['professor'][i].nome + "</option>";
            }

            // Carregado os selects
            $("#professor_id_diario_aula_edit option").remove();
            $("#professor_id_diario_aula_edit").append(htmlProfessor);

            // Setando os valores do model no formulário
            $('#professor_id_diario_aula_edit option[value=' + retorno.data.professor_id  + ']').attr('selected', true);
            $('#data_diario_aula_edit').val(retorno.data.data);
            $('#numero_aula_diario_aula_edit').val(retorno.data.numero_aula);
            $('#carga_horaria_diario_aula_edit').val(retorno.data.carga_horaria);
            $('#hora_inicial_diario_aula_edit').val(retorno.data.hora_inicial);
            $('#hora_final_diario_aula_edit').val(retorno.data.hora_final);
            $('#assunto_ministrado_edit').val(retorno.data.assunto_ministrado);
            
            // Abrindo o modal de inserir disciplina
            $("#modal-edit-diario-aula").modal({show : true});
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Evento para salvar tabela de preços
$('#btnUpdateDiarioAula').click(function() {
    // Recuperando os campos dos formulário
    var professor_id  = $("#professor_id_diario_aula_edit option:selected").val();
    var numero_aula   = $("#numero_aula_diario_aula_edit").val();
    var carga_horaria = $("#carga_horaria_diario_aula_edit").val();
    var hora_inicial  = $("#hora_inicial_diario_aula_edit").val();
    var hora_final    = $("#hora_final_diario_aula_edit").val();
    var data          = $("#data_diario_aula_edit").val();
    var assunto_minis = $("#assunto_ministrado_edit").val();

    // Dados para cadastro
    var dados = {
        'assunto_ministrado' : assunto_minis,
        'professor_id' : professor_id,
        'numero_aula' : numero_aula,
        'carga_horaria': carga_horaria,
        'hora_inicial': hora_inicial,
        'hora_final' : hora_final,
        'data' : data,
        'turma_disciplina_id' : idTurmaDisciplinaDiarioAula
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/tecnico/turma/diarioAula/update/' + idDiarioAula,
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDiarioAula.ajax.reload();
            $('#modal-edit-diario-aula').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});