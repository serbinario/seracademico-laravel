// Variável que armazenará a table de horário
var tableHorario;

// Função para carregar a grid
function loadTableHorario (idAluno, idSemestre) {
    tableHorario = $('#horario-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: "/index.php/seracademico/graduacao/aluno/semestre/gridHorario/"  + idAluno + "/" + idSemestre,
        columns: [
            {data: 'horario', name: 'horario', orderable: false, searchable: false},
            {data: 'domingo', name: 'domingo', orderable: false, searchable: false},
            {data: 'segunda', name: 'segunda', orderable: false, searchable: false},
            {data: 'terca', name: 'terca', orderable: false, searchable: false},
            {data: 'quarta', name: 'quarta', orderable: false, searchable: false},
            {data: 'quinta', name: 'quinta', orderable: false, searchable: false},
            {data: 'sexta', name: 'sexta', orderable: false, searchable: false},
            {data: 'sabado', name: 'sabado', orderable: false, searchable: false}
        ]
    });

    // Executando a arvore de disciplinas
    loadTreeList(idAluno, idSemestre);

    //Retorno
    return tableHorario;
}

// Função para carregar a lista da arvore
function loadTreeList(idAluno, idSemestre)
{
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/aluno/semestre/getTurmas/' + idAluno + "/" + idSemestre,
        datatype: 'json'
    }).done(function (retorno) {
        // Verificando o retorno da requisição
        if(retorno.success) {
            // Variável que armazenará o objeto tree e os nós
            var zTreeObj, zNodes = [];

            // Variável que armazenará as Configurações
            var setting = {};

            // Criando os nós
            $.each(retorno.dados, function (index, value) {
                // Criando o nó pricipal (Disciplina)
                zNodes[index] = {
                    name : value.codigoTurma + " - " +value.nomeDisciplina,
                    open:true,
                    collapse:false,
                    icon:"/img/plugins/zTree/diy/2.png",
                };
            });

            // Criando a árvore e recuperando o objeto ztree
            zTreeObj = $.fn.zTree.init($("#ztree"), setting, zNodes);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
}

// Função para carregar a grid
var tableNotas;
function loadTableNotas (idAluno, idSemestre) {
    tableNotas = $('#semestre-notas-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: "/index.php/seracademico/graduacao/aluno/semestre/gridNotas/" + idAluno + "/" + idSemestre,
        columns: [
            {data: 'nome',  name: 'fac_disciplinas.nome'},
            {data: 'nota_unidade_1', name: 'fac_alunos_notas.nota_unidade_1'},
            {data: 'nota_unidade_2', name: 'fac_alunos_notas.nota_unidade_2'},
            {data: 'nota_2_chamada', name: 'fac_alunos_notas.nota_2_chamada'},
            {data: 'nota_final', name: 'fac_alunos_notas.nota_final'},
            {data: 'nota_media', name: 'fac_alunos_notas.nota_media'},
            {data: 'total_falta', name: 'fac_alunos_frequencias.total_falta'},
            {data: 'nomeSituacao', name: 'fac_situacao_nota.nome'}
        ]
    });

    // retorno
    return tableNotas;
}

// Função para carregar a grid
var tableFaltas;
function loadTableFaltas (idTurma, idSemestre) {
    tableFaltas = $('#semestre-faltas-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: "/index.php/seracademico/graduacao/aluno/semestre/gridFaltas/" + idAluno + "/" + idSemestre,
        columns: [
            {data: 'nome',  name: 'fac_disciplinas.nome'},
            {data: 'falta_mes_1',  name: 'fac_alunos_frequencias.falta_mes_1'},
            {data: 'falta_mes_2',  name: 'fac_alunos_frequencias.falta_mes_2'},
            {data: 'falta_mes_3',  name: 'fac_alunos_frequencias.falta_mes_3'},
            {data: 'falta_mes_4',  name: 'fac_alunos_frequencias.falta_mes_4'},
            {data: 'falta_mes_5',  name: 'fac_alunos_frequencias.falta_mes_5'},
            {data: 'falta_mes_6',  name: 'fac_alunos_frequencias.falta_mes_6'},
            {data: 'total_falta',  name: 'fac_alunos_frequencias.total_falta'},
            {data: 'nomeSituacao', name: 'fac_situacao_nota.nome'}
        ]
    });

    // retorno
    return tableFaltas;
}

// Função para executar a grid
function runSemestre(idAluno, idSemestre) {
    // Carregando a grid de Horários
    if(tableHorario) {
        loadTableHorario(idAluno, idSemestre).ajax.url("/index.php/seracademico/graduacao/aluno/semestre/gridHorario/" + idAluno + "/" + idSemestre).load();
    } else {
        loadTableHorario(idAluno, idSemestre);
    }

    // Carregando a grid de Notas
    if(tableNotas) {
        loadTableNotas(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/semestre/gridNotas/" + idAluno + "/" + idSemestre).load();
    } else {
        loadTableNotas(idAluno, idSemestre);
    }

    // Carregando a grid de Faltas
    if(tableFaltas) {
        loadTableFaltas(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/semestre/gridFaltas/" + idAluno + "/" + idSemestre).load();
    } else {
        loadTableFaltas(idAluno, idSemestre);
    }

    // Carregando as opções de gerenciar disciplinas
    runGerenciarDisciplina(idAluno, idSemestre);

    // carregando a modal
    $("#modal-semestre").modal({show:true});
}

/**
 * Função para carregar as dependências da aba de gerenciar disciplinas
 * @param idAluno
 * @param idSemestre
 */
function runGerenciarDisciplina(idAluno, idSemestre)
{
    // Carregando a grid de Horários
    if(tableGerenciarDisciplinasHorario) {
        loadtableGerenciarDisciplinasHorario(idAluno, idSemestre).ajax.url("/index.php/seracademico/graduacao/aluno/semestre/gridHorario/" + idAluno + "/" + idSemestre).load();
    } else {
        loadtableGerenciarDisciplinasHorario(idAluno, idSemestre);
    }

    // Verificando se a tabela já foi carregada
    if(!tableDisciplina) {
        loadTableDisciplina(idAluno);
    } else {
        // Recarregando a tableDisciplina
        tableDisciplina.ajax.url("/index.php/seracademico/graduacao/aluno/semestre/gridDisciplina/" + idAluno).load();
    }

    // Carregando as opções de remoção de horários
    builderDisciplinasAlunoSemestre(idAluno, idSemestre);
}