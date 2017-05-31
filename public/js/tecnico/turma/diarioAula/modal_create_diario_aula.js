$('#modal-create-diario-aula').on('hidden.bs.modal', function () {
    // Removendo as linhas da grid
    if (tableConteudoProgramaticoDiarioAulaCreate) {
        tableConteudoProgramaticoDiarioAulaCreate.rows().remove().draw();
    }
});

// Evento para chamar o modal de adicionar matéria ao curso
$(document).on("click", "#btnCreateDiarioAula", function () {
    loadFieldsDiarioAula();
});

// carregando todos os campos preenchidos
function loadFieldsDiarioAula()
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
            builderHtmlFieldsDiarioAula(retorno);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
            $('#modal-create-beneficio').modal('toggle');
        }
    });
};

// Função a montar o html
function builderHtmlFieldsDiarioAula (dados) {
    //Limpando os campos
    $('#professor_id_diario_aula option').attr('selected', false);
    $('#data_diario_aula').val('');
    $('#numero_aula_diario_aula').val('');
    $('#carga_horaria_diario_aula').val('');
    $('#hora_inicial_diario_aula').val('');
    $('#hora_final_diario_aula').val('');
    $('#assunto_ministrado').val('');
    $("#conteudo_programatico_diario_aula").select2("val", "");


    // Variáveis que armazenaram o html
    var htmlProfessor = "<option value=''>Selecione um Professor</option>";

    // Percorrendo o array de tipos valores
    for (var i = 0; i < dados['professor'].length; i++) {
        htmlProfessor += "<option value='" + dados['professor'][i].id + "'>" + dados['professor'][i].nome + "</option>";
    }

    // Carregado os selects
    $("#professor_id_diario_aula option").remove();
    $("#professor_id_diario_aula").append(htmlProfessor);

    // Abrindo o modal de inserir disciplina
    $("#modal-create-diario-aula").modal({show : true});
}

// Evento para salvar histórico
$('#btnSaveDiarioAula').click(function() {
    // Recuperando os campos dos formulário
    var assunto_minis = $("#assunto_ministrado").val();
    var professor_id  = $("#professor_id_diario_aula option:selected").val();    
    var numero_aula   = $("#numero_aula_diario_aula").val();
    var carga_horaria = $("#carga_horaria_diario_aula").val();
    var hora_inicial  = $("#hora_inicial_diario_aula").val();
    var hora_final    = $("#hora_final_diario_aula").val();
    var data          = $("#data_diario_aula").val();
    var conteudos     = [];

    // Carregando as taxas
    $.each(tableConteudoProgramaticoDiarioAulaCreate.rows().data(),function (index, val) {
        conteudos[index] = val[0];
    });

    // Dados para cadastro
    var dados = {
        'assunto_ministrado': assunto_minis,
        'professor_id' : professor_id,
        'conteudos' : conteudos,
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
        url: '/index.php/seracademico/tecnico/turma/diarioAula/store',
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableDiarioAula.ajax.reload();

            // Removendo as linhas da grid
            if (tableConteudoProgramaticoDiarioAulaCreate) {
                tableConteudoProgramaticoDiarioAulaCreate.rows().remove().draw();
            }

            $('#modal-create-diario-aula').modal('toggle');
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            // Mensagem de erro
            var msg = "";

            // Verificando o tipo de mensagem
            if(retorno.validator) {console.log(retorno.validator);
                // se for mensagem de validação
                $.each(retorno.msg, function (index, valor) {
                    msg += valor + "\n";
                });
            } else {
                msg = retorno.msg;
            }

            // Exibe a mensagem
            swal(msg, "Click no botão abaixo!", "error");
        }
    });
});

// Evento para o click no botão de remover disciplina
$(document).on('click', '#btnDeleteDiarioAula', function () {
    // recuperando o id do diário de aula
    var diarioAulaId = tableDiarioAula.row($(this).parents('tr')).data().id;

    // Requisição ajax
    jQuery.ajax({
        type: 'DELETE',
        url: '/index.php/seracademico/tecnico/turma/diarioAula/delete/' + diarioAulaId,
        datatype: 'json'
    }).done(function (retorno) {
        tableDiarioAula.ajax.reload();
        
        swal(retorno.msg, "Click no botão abaixo!", "success");
    });
});

