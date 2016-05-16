// variável de tabela de notas
var tableNotas;

// Função para carregamento da tabela de notas
function loadTableNotas(idVestibulando) {
    tableNotas = $('#notas-grid').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/vestibulando/notas/grid/" + idVestibulando,
        columns: [
            {data: 'codigo', name: 'fac_materias.codigo'},
            {data: 'nome', name: 'fac_materias.nome'},
            {data: 'acertos', name: 'aluno_notas_vestibular.acertos'},
            {data: 'pontuacao', name: 'aluno_notas_vestibular.pontuacao'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
}

// Função para executar a tabela de notas
function runTableNotas(idVestibulando) {
    if(tableNotas) {
        tableNotas.ajax.url("/index.php/seracademico/vestibulando/notas/grid/" + idVestibulando).load();
    } else {
        loadTableNotas(idVestibulando);
    }

    // Abrindo o modal
    $('#modal-notas').modal({show:true});
}