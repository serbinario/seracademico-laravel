// Evento para o fechamento do modal de adicionar disciplina
$('#btnCloseAddDisciplina').click(function () { console.log('dsadsa');
    $('#modal-adicionar-disciplina-curriculo').modal('toggle');
    loadTableAdicionarDisciplina(idCurriculo).ajax.url("/index.php/seracademico/posgraduacao/curriculo/gridByCurriculo/" + 0).load();
});

// Carregando a table
var tableAdicionarDisciplina;
function loadTableAdicionarDisciplina (idCurriculo) {
    // Carregaando a grid
    tableAdicionarDisciplina = $('#add-disciplina-curriculo').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: true,
        autoWidth: false,
        ajax:  "/index.php/seracademico/posgraduacao/curriculo/gridByCurriculo/" + idCurriculo,
        columns: [
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'qtd_faltas', name: 'fac_curriculo_disciplina.qtd_faltas'},
            {data: 'carga_horaria_total', name: 'fac_curriculo_disciplina.carga_horaria_total'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Retorno
    return tableAdicionarDisciplina;
}

// Executando a grid
function runTableAdicionarDisciplina (idCurriculo) {
    loadTableAdicionarDisciplina(idCurriculo).ajax.url("/index.php/seracademico/posgraduacao/curriculo/gridByCurriculo/" + idCurriculo).load();
}