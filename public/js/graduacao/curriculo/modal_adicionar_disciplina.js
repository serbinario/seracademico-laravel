/*Datatable da grid adicionar disciplina*/
var tableAdicionarDisciplina;
function loadTableAdicionarDisciplina (idCurriculo) {
    // Carregaando a grid
    tableAdicionarDisciplina = $('#add-disciplina-curriculo').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/curriculo/gridByCurriculo/" + idCurriculo,
        columns: [
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
            {data: 'qtd_falta', name: 'fac_disciplinas.qtd_falta'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'carga_horaria_pratica', name: 'fac_disciplinas.carga_horaria_pratica'},
            {data: 'carga_horaria_teorica', name: 'fac_disciplinas.carga_horaria_teorica'},
            {data: 'qtd_credito', name: 'fac_disciplinas.qtd_credito'},
            {data: 'tipo_disciplina', name: 'fac_tipo_disciplinas.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Retorno
    return tableAdicionarDisciplina;
}

// Executando a grid
function runTableAdicionarDisciplina (idCurriculo) {
    loadTableAdicionarDisciplina(idCurriculo).ajax.url("/index.php/seracademico/graduacao/curriculo/gridByCurriculo/" + idCurriculo).load();
}