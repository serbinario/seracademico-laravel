// variáveis de grid
var tableConteudoPlanoAula, tableConteudoPlanoAulaEditar;

// Função que carrega o a grid de conteudo programatico para criacao
function loadCreateTableConteudoProgramaticoPlanoAula()
{
    tableConteudoPlanoAula = $('#grid-conteudo-programatico-plano-aula').DataTable({
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        retrieve: true,
        columnDefs: [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ]
    });

    return tableConteudoPlanoAula;
}


// Função que carrega o a grid de conteudo programatico para edição
function loadEditTableConteudoProgramaticoPlanoAulaEditar(idPlanoAula)
{
    tableConteudoPlanoAulaEditar = $('#grid-conteudo-programatico-plano-aula-editar').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/planoEnsino/planoAula/gridConteudos/" + idPlanoAula,
        columns: [
            {data: 'nome', name: 'nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableConteudoPlanoAulaEditar;
}