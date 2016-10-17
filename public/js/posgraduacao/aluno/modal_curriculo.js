// Evento quando o modal fechar
$('#modal-curriculo').on('hidden.bs.modal', function () {
    loadTableDisciplinasACursar(0).ajax.url("/index.php/seracademico/posgraduacao/aluno/curriculo/gridACursar/" + 0).load();
    loadTableDisciplinasCursadas(0).ajax.url("/index.php/seracademico/posgraduacao/aluno/curriculo/gridCursadas/" + 0).load();
})

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
        ajax: "/index.php/seracademico/posgraduacao/aluno/curriculo/gridACursar/" + idAlunoTurma,
        columns: [
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo'},
            {data: 'disciplina_nome', name: 'fac_disciplinas.nome'},
            {data: 'turma_codigo', name: 'fac_turmas.codigo'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'}
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
        ajax: "/index.php/seracademico/posgraduacao/aluno/curriculo/gridCursadas/" + idAlunoTurma,
        columns: [
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo'},
            {data: 'disciplina_nome', name: 'fac_disciplinas.nome'},
            {data: 'turma_codigo', name: 'fac_turmas.codigo'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'},
            {data: 'nota_final', name: 'pos_alunos_notas.nota_final'},
            {data: 'situacao', name: 'fac_situacao_nota.nome'}
        ]
    });

    // Retorno
    return tableDisciplinasCursadas;
}

// // carregamento da grid de disciplinas cursadas
var tableDisciplinasDispensadas;
function loadTableDisciplinasDispensadas(idAlunoTurma) {
    tableDisciplinasDispensadas = $('#grid-dispensadas').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        //bPaginate: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/curriculo/gridDispensadas/" + idAlunoTurma,
        columns: [
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo'},
            {data: 'disciplina_nome', name: 'fac_disciplinas.nome'},
            {data: 'nota_final', name: 'pos_alunos_dispensadas.nota_final'},
            {data: 'carga_horaria', name: 'pos_alunos_dispensadas.carga_horaria'},
            {data: 'qtd_credito', name: 'pos_alunos_dispensadas.qtd_credito'},
            {data: 'motivo', name: 'fac_motivos.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Retorno
    return tableDisciplinasDispensadas;
}

// Função para executar a grid
function runCurriculo(idAluno) {
    // Carregando a grid de ACursar
    if(tableDisciplinasACursar) {
        loadTableDisciplinasACursar(idAluno).ajax.url("/index.php/seracademico/posgraduacao/aluno/curriculo/gridACursar/" + idAluno).load();
    } else {
        loadTableDisciplinasACursar(idAluno);
    }

    // Carregando a grid de cursadas
    if(tableDisciplinasCursadas) {
        loadTableDisciplinasCursadas(idAluno).ajax.url("/index.php/seracademico/posgraduacao/aluno/curriculo/gridCursadas/" + idAluno).load();
    } else {
        loadTableDisciplinasCursadas(idAluno);
    }

    // Carregando a grid de dispensadas
    if(tableDisciplinasDispensadas) {
        loadTableDisciplinasDispensadas(idAluno).ajax.url("/index.php/seracademico/posgraduacao/aluno/curriculo/gridDispensadas/" + idAluno).load();
    } else {
        loadTableDisciplinasDispensadas(idAluno);
    }

    // carregando a modal
    $("#modal-curriculo").modal({show:true});
}