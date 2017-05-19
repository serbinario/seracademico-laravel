// Função que carrega o a grid de conteudo programatico para criacao
function loadCreateTableConteudoProgramatico()
{
    tableConteudoProgramatico = $('#grid-conteudo-programatico').DataTable({
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false
    });
}


// Função que carrega o a grid de conteudo programatico para edição
function loadEditTableConteudoProgramatico(idPlanoEnsino)
{
    tableConteudoProgramatico = $('#grid-conteudo-programatico').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/posgraduacao/planoensino/gridConteudoProgramatico/" + idPlanoEnsino,
        columns: [
            {data: 'nome', name: 'nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
}