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
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo', orderable: false},
            {data: 'disciplina_nome', name: 'fac_disciplinas.nome', orderable: false},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria', orderable: false},
            {data: 'turma_codigo', name: 'fac_turmas.codigo', orderable: false},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito', orderable: false}
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
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo', orderable: false, searchable: false},
            {data: 'disciplina_nome', name: 'fac_disciplinas.nome', orderable: false, searchable: false},
            {data: 'turma_codigo', name: 'fac_turmas.codigo', orderable: false, searchable: false},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria', orderable: false, searchable: false},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito', orderable: false, searchable: false},
            {data: 'nota_final', name: 'pos_alunos_notas.nota_final', orderable: false, searchable: false},
            {data: 'situacao', name: 'fac_situacao_nota.nome', orderable: false, searchable: false}
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
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo', orderable: false, searchable: false},
            {data: 'disciplina_nome', name: 'fac_disciplinas.nome', orderable: false, searchable: false},
            {data: 'nota_final', name: 'pos_alunos_dispensadas.nota_final', orderable: false, searchable: false},
            {data: 'carga_horaria', name: 'pos_alunos_dispensadas.carga_horaria', orderable: false, searchable: false},
            {data: 'qtd_credito', name: 'pos_alunos_dispensadas.qtd_credito', orderable: false, searchable: false},
            {data: 'motivo', name: 'fac_motivos.nome', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Retorno
    return tableDisciplinasDispensadas;
}

// Função para carregar a grid
var tableDisciplinasExtraCurricular;
function loadTableDisciplinasExtraCurricular (idAluno) {
    tableDisciplinasExtraCurricular = $('#grid-extras').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/curriculo/gridDisciplinasExtraCurricular/" + idAluno,
        columns: [
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo'},
            {data: 'disciplina_nome', name: 'fac_disciplinas.nome'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'},
            {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableDisciplinasExtraCurricular;
}

// Função para carregar a grid
var tableDisciplinasEquivalentes;
function loadTableDisciplinasEquivalentes (idAluno) {
    tableDisciplinasEquivalentes = $('#grid-equivalencias').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/posgraduacao/aluno/curriculo/gridDisciplinasEquivalentes/" + idAluno,
        columns: [
            {data: 'disciplina_codigo', name: 'fac_disciplinas.codigo'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'},
            {data: 'equivalente_codigo', name: 'equivalente.codigo'},
            {data: 'codigoCurriculo', name: 'curriculo_equiavalente.codigo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableDisciplinasEquivalentes;
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

    // Carregando a grid de extras curriculares
    if(tableDisciplinasExtraCurricular) {
        loadTableDisciplinasExtraCurricular(idAluno).ajax.url("/index.php/seracademico/posgraduacao/aluno/curriculo/gridDisciplinasExtraCurricular/" + idAluno).load();
    } else {
        loadTableDisciplinasExtraCurricular(idAluno);
    }

    // Carregando a grid de extras curriculares
    if(tableDisciplinasEquivalentes) {
        loadTableDisciplinasEquivalentes(idAluno).ajax.url("/index.php/seracademico/posgraduacao/aluno/curriculo/gridDisciplinasEquivalentes/" + idAluno).load();
    } else {
        loadTableDisciplinasEquivalentes(idAluno);
    }

    // carregando a modal
    $("#modal-curriculo").modal({show:true});
}