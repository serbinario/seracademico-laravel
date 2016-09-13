// Função que carrega o a grid de conteudo programatico para criacao
function loadCreateTableBeneficio()
{
    tableBeneficioDebitoAluno = $('#grid-debitos-beneficios').DataTable({
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        columnDefs: [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ]
    });
}


// Função que carrega o a grid de conteudo programatico para edição
function loadEditTableBeneficio(idDebito)
{
    tableBeneficioDebitoAluno = $('#grid-debitos-beneficios').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/index.php/seracademico/graduacao/aluno/financeiro/beneficio/" + idDebito,
        columns: [
            {data: 'nome', name: 'nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
}