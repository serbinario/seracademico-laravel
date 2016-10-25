// carregamento da grid de cursos e turmas
var tableCursoTurma;
function loadTableCursoTurma(idAluno) {
    tableCursoTurma = $('#curso-turma-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        //bPaginate: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/turma/grid/" + idAluno,
        columns: [
            {data: 'codigo_curso', name: 'fac_cursos.codigo'},
            // {data: 'nome_curso', name: 'fac_cursos.nome'},
            {data: 'codigo_curriculo', name: 'fac_curriculos.codigo'},
            // {data: 'nome_curriculo', name: 'fac_curriculos.nome'},
            {data: 'situacao_aluno', name: 'fac_situacao_aluno.nome'},
            {data: 'aula_inicio', name: 'fac_turmas.aula_inicio'},
            {data: 'codigo_turma', name: 'fac_turmas.codigo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableCursoTurma;
}

// carregamento da grid de situações
var tableSituacoes;
function loadTableSituacoes(idAlunoCurso) {
    tableSituacoes = $('#situacao-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        //bPaginate: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/turma/gridSituacoes/" + idAlunoCurso,
        columns: [
            {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
            {data: 'codigoCurso', name: 'fac_cursos.codigo'},
            {data: 'nomeSituacao', name: 'fac_situacao.nome'},
            {data: 'codigoOrigem', name: 'origem.codigo'},
//            {data: 'codigoDestino', name: 'destino.codigo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableSituacoes;
}

// Variável que armazenará o id do pivot
// de aluno e curriculo
var idAlunoCurso;

// evento para abrir todas as grids de disciplinas
$(document).on("click", "#curso-turma-grid tbody tr", function (event) {
    if (tableCursoTurma.rows().data().length > 0  && $(event.target).is("td")) {
        $(this).parent().find("tr td").removeClass('row_selected');
        $(this).find("td").addClass("row_selected");

        //Recuperando o id da turma selecionada e o index da linha selecionada
        idAlunoCurso = tableCursoTurma.row($(this).index()).data().idAlunoCurso;
        indexRowSelectedCurso =  $(this).index();

        // habilitando o butão
        $('#btnAdicionarSituacao').removeAttr('disabled');

        //Carregando as grids de situações
        if(tableSituacoes) {
            loadTableSituacoes(idAlunoCurso).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridSituacoes/" + idAlunoCurso).load();
        } else {
            loadTableSituacoes(idAlunoCurso);
        }


        // loadTableDisciplinasACursar(idAlunoTurma).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridACursar/" + idAlunoTurma).load();
        // loadTableDisciplinasCursadas(idAlunoTurma).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridCursadas/" + idAlunoTurma).load();
        // loadTableDisciplinasDispensadas(idAlunoTurma).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridDispensadas/" + idAlunoTurma).load();
    }
});

// Função responsável por carregar o modal
function runCursoTurma(idAluno) {
    // desabilitando o butão
    $('#btnAdicionarSituacao').attr('disabled', true);

    // Carregando a grid de alunos cursos
    if(tableCursoTurma) {
        loadTableCursoTurma(idAluno).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/grid/" + idAluno).load();
    } else {
        loadTableCursoTurma(idAluno);
    }

    // Carregamento inicial
    loadTableSituacoes(0).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridSituacoes/" + 0).load();


    // Exibindi o modal
    $("#modal-turma-aluno").modal({show:true});
}

// Evento para remover a situação
$(document).on('click', '#btnRemoverCurso', function () {
    // Recuperando o id da situação do aluno
    var id = tableCursoTurma.row($(this).parents('tr')).data().idAlunoCurso;
    var idAluno = tableCursoTurma.row($(this).parents('tr')).data().idAluno;

    // Requisição ajax
    jQuery.ajax({
        type: 'DELETE',
        url: '/index.php/seracademico/posgraduacao/aluno/turma/destroy/' + idAluno + '/' + id,
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Recarregando as grids
            tableCursoTurma.ajax.reload();
            loadTableSituacoes(0).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridSituacoes/" + 0).load();

            // desabilitando o butão
            $('#btnAdicionarSituacao').attr('disabled', true);

            // Mensagem de retorno
            swal(retorno.msg, "Click no botão abaixo!", "success");
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});
