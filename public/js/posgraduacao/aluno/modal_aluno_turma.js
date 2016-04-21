// carregamento da grid de cursos e turmas
var tableCursoTurma;
function loadTableCursoTurma(idAluno) {
    tableCursoTurma = $('#curso-turma-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        //bFilter: false,
        //bPaginate: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/turma/grid/" + idAluno,
        columns: [
            {data: 'codigo_curso', name: 'fac_cursos.codigo'},
            {data: 'nome_curso', name: 'fac_cursos.nome'},
            {data: 'codigo_curriculo', name: 'fac_curriculos.codigo'},
            {data: 'nome_curriculo', name: 'fac_curriculos.nome'},
            {data: 'situacao_aluno', name: 'fac_situacao_aluno.nome'},
            {data: 'aula_inicio', name: 'fac_turmas.aula_inicio'},
            {data: 'codigo_turma', name: 'fac_turmas.codigo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
}

// carregamento da grid de disciplinas a cursar
var tableDisciplinasACursar;
function loadTableDisciplinasACursar(idAlunoTurma) {
    tableDisciplinasACursar = $('#grid-acursar').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        //bFilter: false,
        //bPaginate: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/turma/gridACursar/" + idAlunoTurma,
        columns: [
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo'},
            //{data: 'disciplina_nome', name: 'fac_disciplinas.nome'},
            {data: 'turma_codigo', name: 'fac_turmas.codigo'},
            {data: 'media', name: 'fac_notas.media'},
            {data: 'situacao_nota_nome', name: 'fac_situacao_nota.nome'}
        ]
    });

    // Retorno
    return tableDisciplinasACursar;
}

// carregamento da grid de disciplinas cursadas
var tableDisciplinasCursadas;
function loadTableDisciplinasCursadas(idAlunoTurma) {
    tableDisciplinasCursadas = $('#grid-cursadas').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        //bFilter: false,
        //bPaginate: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/turma/gridCursadas/" + idAlunoTurma,
        columns: [
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo'},
            //{data: 'disciplina_nome', name: 'fac_disciplinas.nome'},
            {data: 'turma_codigo', name: 'fac_turmas.codigo'},
            {data: 'media', name: 'fac_notas.media'},
            {data: 'situacao_nota_nome', name: 'fac_situacao_nota.nome'}
        ]
    });

    // Retorno
    return tableDisciplinasCursadas;
}

// carregamento da grid de disciplinas cursadas
var tableDisciplinasDispensadas;
function loadTableDisciplinasDispensadas(idAlunoTurma) {
    tableDisciplinasDispensadas = $('#grid-dispensadas').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        //bFilter: false,
        //bPaginate: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/turma/gridDispensadas/" + idAlunoTurma,
        columns: [
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo'},
            //{data: 'disciplina_nome', name: 'fac_disciplinas.nome'},
            {data: 'turma_codigo', name: 'fac_turmas.codigo'},
            {data: 'media', name: 'fac_notas.media'},
            {data: 'situacao_nota_nome', name: 'fac_situacao_nota.nome'}
        ]
    });

    // Retorno
    return tableDisciplinasDispensadas;
}

// evento para abrir todas as grids de disciplinas
$(document).on("click", "#curso-turma-grid tbody tr", function () {
    if (tableCursoTurma.rows().data().length > 0) {
        $(this).parent().find("tr td").removeClass('row_selected');
        $(this).find("td").addClass("row_selected");

        //Recuperando o id da turma selecionada e o index da linha selecionada
        console.log("ddddddddd");
        idAlunoTurma = tableCursoTurma.row($(this).index()).data().id;
        //indexRowSelectedDisciplina =  $(this).index();

        //Carregando as grids de disciplinas
        loadTableDisciplinasACursar(idAlunoTurma).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridACursar/" + idAlunoTurma).load();
        loadTableDisciplinasCursadas(idAlunoTurma).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridCursadas/" + idAlunoTurma).load();
        loadTableDisciplinasDispensadas(idAlunoTurma).ajax.url("/index.php/seracademico/posgraduacao/aluno/turma/gridDispensadas/" + idAlunoTurma).load();
    }
});

// evento para abrir modal de adicionar curso ao aluno
$(document).on("click", "#adicionar-curso", function () {
    loadFields();
    loadCursosAluno();

    $("#modal-nova-turma-aluno").modal({show:true});
});

// grid de disciplinas a cursar