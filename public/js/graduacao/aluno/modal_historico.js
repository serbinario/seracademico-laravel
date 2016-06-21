//Desativando o botão de adicionar preço por disciplinas
$("#btnAddSituacao").prop("disabled", true);

// // Evento quando fechar a modal
// $(document).on('click', '#closeModalPrecoCurso', function () {
//     $("#btnAddPrecoDisciplina").prop("disabled", true);
//     loadTablePrecosDisciplinaCurso(0).ajax.url("/index.php/seracademico/graduacao/curso/precos/disciplina/grid/" + 0).load();
// });

// Função para carregar a grid
var tableHistorico;
function loadTableHistorico (idAluno) {
    tableHistorico = $('#grid-historico').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/historico/grid/" + idAluno,
        columns: [
            {data: 'nomeSemestre', name: 'fac_semestres.nome'},
            {data: 'codigoCurso', name: 'fac_cursos.codigo'},
            {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
            // {data: 'codigoSituacao', name: 'fac_situacao.codigo'},
            {data: 'nomeSituacao', name: 'fac_situacao.nome'},
            {data: 'periodo', name: 'fac_semestres.periodo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableHistorico;
}

// Função para carregar a grid
var tableSituacao;
function loadTableSituacao (idAlunoSemestre) {
    tableSituacao = $('#grid-situacao').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/historico/situacao/grid/" + idAlunoSemestre,
        columns: [
            {data: 'id', name: 'fac_alunos_situacoes.id'},
            {data: 'data', name: 'fac_alunos_situacoes.data'},
            //{data: 'codigoSituacao', name: 'fac_situacao.codigo'},
            {data: 'nomeSituacao', name: 'fac_situacao.nome'},
            {data: 'codigoCursoOrigem', name: 'cursoOrigem.codigo'},
            {data: 'codigoCursoDestino', name: 'cursoDestino.codigo'},
            {data: 'observacao', name: 'fac_alunos_situacoes.observacao'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableSituacao;
}

// Função para executar a grid
function runHistorico(idAluno) {
    // Carregando a grid
    if(tableHistorico) {
        loadTableHistorico(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/historico/grid/" + idAluno).load();
    } else {
        loadTableHistorico(idAluno);
    }

    // carregando a modal
    $("#modal-historico").modal({show:true});
}

// Id da tabela do pivot de aluno e semestre e o id do semestre
var idAlunoSemestre, idSemestre;

// Evento para carregar grid de precos por disciplinas
$(document).on('click', '#grid-historico tbody tr', function (event) {
    // Verificando se existe linhas na tabela
    if (tableHistorico.rows().data().length > 0 && $(event.target).is("td")) {
        $(this).parent().find("tr td").removeClass('row_selected');
        $(this).find("td").addClass("row_selected");

        //Ativando o botão de adicionar disciplina
        $("#btnAddSituacao").prop("disabled", false);

        //Recuperando o id da turma selecionada e o index da linha selecionada
        idAlunoSemestre = tableHistorico.row($(this).index()).data().idAlunoSemestre;
        idSemestre      = tableHistorico.row($(this).index()).data().idSemestre;
        indexRowSelectedHistorico =  $(this).index();

        // carregando a grid de situacoes
        loadTableSituacao(idAlunoSemestre).ajax.url("/index.php/seracademico/graduacao/aluno/historico/situacao/grid/" + idAlunoSemestre).load();
    }
});
