// Variável que armazenará o id da disciplina
var disciplinaPlanoEnsinoId;

// Função para carregar a grid
var tableDisciplinasPlanoEnsino;
function loadTableDisciplinasPlanoEnsino (idTurma) {
    tableDisciplinasPlanoEnsino = $('#plano-ensino-disciplina-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/graduacao/turma/planoEnsino/gridDisciplinas/" + idTurma,
        columns: [
            {data: 'codigo', name: 'fac_disciplinas.codigo', orderable: false},
            {data: 'nome', name: 'fac_disciplinas.nome', orderable: false},
            {data: 'planoEnsino', name: 'planoEnsino', orderable: false}
        ]
    });

    return tableDisciplinasPlanoEnsino;
}

// Função para executar a grid
function runTablePlanoEnsino(idTurma) {
    // Verificando se a grid está carregada
    if (tableDisciplinasPlanoEnsino) {
        tableDisciplinasPlanoEnsino.ajax.url("/index.php/seracademico/graduacao/turma/planoEnsino/gridDisciplinas/" + idTurma).load();
    } else {
        loadTableDisciplinasPlanoEnsino(idTurma);
    }

    // exibindo o modal
    $('#modal-plano-ensino').modal({show: true, keyboard: true});
}

// Evento quando clicar numa coluna
$(document).on('click', '#plano-ensino-disciplina-grid tbody tr td', function () {
    // Removendo todos os css
    $(this).parent().parent().find('td').removeClass('column_selected');

    if($(this).text() != "" && $(this).index() != 0) {
        // Fazendo a lógica de seleção para o css
        $(this).parent().find('td').addClass('column_selected');

        // Recuperando os valores úteis
        disciplinaPlanoEnsinoId = tableDisciplinasPlanoEnsino.row($(this).parent().index()).data().idDisciplina;
        var cargaHoraria = tableDisciplinasPlanoEnsino.row($(this).parent().index()).data().carga_horaria_total;

        // Definindo os models
        var dados =  {
            'idTurma': idTurma,
            'disciplinaId' : disciplinaPlanoEnsinoId,
            'models' : [
                'Graduacao\\PlanoEnsino|byDisciplinaAndCargaHoraria,' + disciplinaPlanoEnsinoId + ',' + cargaHoraria
            ]
        };

        // Fazendo a requisição ajax
        jQuery.ajax({
            type: 'POST',
            data: dados,
            url: '/index.php/seracademico/graduacao/turma/planoEnsino/getLoadFields',
            datatype: 'json'
        }).done(function (retorno) {
            // Variáveis que armazenaram o html
            var htmlPlanoEnsino     = "<option value=''>Selecione um plano de ensino</option>";

            // Verificando o retorno da requisição
            if(retorno['graduacao\\planoensino'].length > 0) {
                // Percorrendo o array de disciplinacurriculo
                for(var i = 0; i < retorno['graduacao\\planoensino'].length; i++) {
                    // Criando as options
                    htmlPlanoEnsino += "<option value='" + retorno['graduacao\\planoensino'][i].id + "'>" + retorno['graduacao\\planoensino'][i].nome + "</option>";
                }

                // Removendo e adicionando as options de período
                $("#planoEnsino option").remove();
                $("#planoEnsino").append(htmlPlanoEnsino);

                // Selecionando o plano de ensino
                $("#planoEnsino option[value=" + retorno['turmaDisciplina'].plano_ensino_id + "]").attr('selected', true);
            } else {
                // Removendo e adicionando as options de período
                $("#planoEnsino option").remove();
                $("#planoEnsino").append(htmlPlanoEnsino);

                // Retorno caso não tenha currículo em uma turma ou algum erro
                swal("Desculpe não existe Planos de Ensino disponíveis", "Click no botão abaixo!", "error");
            }
        });
    }
});

// Função para limpar o select de plano de ensino
function cleanSelectPlanoEnsino() {
    // Variáveis que armazenaram o html
    var htmlPlanoEnsino     = "<option value=''>Selecione um plano de ensino</option>";

    // Removendo e adicionando as options de período
    $("#planoEnsino option").remove();
    $("#planoEnsino").append(htmlPlanoEnsino);
}

// Evento para vincular o plano de ensino a disciplina
$(document).on('click', '#addPlanoEnsino', function () {
    // Recuperando os valores úteis
    var planoEnsinoId = $('#planoEnsino option:selected').val();

    // Validação
    if(!planoEnsinoId || planoEnsinoId == "") {
        swal('Você deve escolher um plano de ensino', 'Click em Ok para sair!', 'error');
        return false;
    }

    // Dados de envio
    var dados = {
        'idTurma' : idTurma,
        'disciplinaId' : disciplinaPlanoEnsinoId,
        'planoEnsinoId' : planoEnsinoId
    };

    // Fazendo a requisição
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/graduacao/turma/planoEnsino/attachPlanoEnsino',
        datatype: 'json'
    }).done(function (retorno) {
        swal(retorno['msg'], retorno['success'] ? 'success' : 'error')
        tableDisciplinasPlanoEnsino.ajax.reload();
        cleanSelectPlanoEnsino();
    });
});
