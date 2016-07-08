// Função para carregar a grid
var tableACursar;
function loadTableACursar (idAluno) {
    tableACursar = $('#grid-acursar').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridACursar/" + idAluno,
        columns: [
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'}
        ]
    });

    return tableACursar;
}

// Função para carregar a grid
var tableCursadas;
function loadTableCursadas (idAluno) {
    tableCursadas = $('#grid-cursadas').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/curriculo/gridCursadas/" + idAluno,
        columns: [
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'}
        ]
    });

    return tableCursadas;
}

// Função para executar a grid
function runCurriculo(idAluno) {
    // Carregando a grid de ACursar
    if(tableACursar) {
        loadTableACursar(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridACursar/" + idAluno).load();
    } else {
        loadTableACursar(idAluno);
    }

    // Carregando a grid de cursadas
    if(tableCursadas) {
        loadTableCursadas(idAluno).ajax.url("/index.php/seracademico/graduacao/aluno/curriculo/gridCursadas/" + idAluno).load();
    } else {
        loadTableCursadas(idAluno);
    }

    // carregando a modal
    $("#modal-curriculo").modal({show:true});
}