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
        ajax: {
            url: "/index.php/seracademico/graduacao/curriculo/gridByCurriculo/" + idCurriculo,
            data: function (d) {
                d.periodo = $('input[name=periodoSearch]').val();
            }
        },
        columns: [
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
            {data: 'qtd_faltas', name: 'fac_curriculo_disciplina.qtd_faltas'},
            {data: 'carga_horaria_total', name: 'fac_curriculo_disciplina.carga_horaria_total'},
            {data: 'carga_horaria_pratica', name: 'fac_curriculo_disciplina.carga_horaria_pratica'},
            {data: 'carga_horaria_teorica', name: 'fac_curriculo_disciplina.carga_horaria_teorica'},
            {data: 'qtd_credito', name: 'fac_curriculo_disciplina.qtd_credito'},
            {data: 'tipo_disciplina', name: 'fac_tipo_disciplinas.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#search-form').on('submit', function(e) {
        tableAdicionarDisciplina.draw();
        e.preventDefault();
    });

    // Retorno
    return tableAdicionarDisciplina;
}

// Executando a grid
function runTableAdicionarDisciplina (idCurriculo) {
    loadTableAdicionarDisciplina(idCurriculo).ajax.url("/index.php/seracademico/graduacao/curriculo/gridByCurriculo/" + idCurriculo).load();
}