/**
 * Created by Fabio Aguiar on 20/03/2017.
 */

$(document).ready(function () {

    function format(d) {

        var exemplar = d['exemplares'];

        var html = "<table class='table table-bordered'>";
        html += "<thead>" +
            "<tr><td>Título</td><td>Subtitulo</td><td>Número de chamada</td><td>Tombo</td></tr>" +
            "</thead>";

        for (var i = 0; i < exemplar.length; i++) {
            html += "<tr>";
            html += "<td>" + exemplar[i]['titulo'] + "</td>";
            html += "<td>" + exemplar[i]['subtitulo'] + "</td>";
            html += "<td>" + exemplar[i]['numero_chamada'] + "</td>";
            html += "<td>" + exemplar[i]['tombo'] + "</td>";
            html += "</tr>"
        }
        html += "</table>";

        return  html;
    }

    var table = $('#individual-grid').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false,
        order: [[ 1, "asc" ]],
        ajax: {
            url: "/index.php/seracademico/biblioteca/devolucaoEmprestimo",
            data: function (d) {
                d.globalSearch = $('input[name=globalSearch]').val();
            }
        },
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           'pessoas.nome',
                "defaultContent": ''
            },
            {data: 'codigo', name: 'bib_emprestimos.codigo'},
            {data: 'data', name: 'bib_emprestimos.data'},
            {data: 'data_devolucao', name: 'bib_emprestimos.data_devolucao'},
            {data: 'data_devolucao_real', name: 'bib_emprestimos.data_devolucao_real'},
            {data: 'nome', name: 'pessoas.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Função do submit do search da grid principal
    $('#search-form').on('submit', function(e) {
        table.draw();
        e.preventDefault();
    });

    // Add event listener for opening and closing details
    $('#individual-grid tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });
});

$(document).on('click', 'a.excluir', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    bootbox.confirm("Tem certeza que deseja devolver esse emprestimo?", function (result) {
        if (result) {
            window.open(url, '_blank');
            location.reload();
            //location.href = url
        } else {
            false;
        }
    });
});

$(document).on('click', 'a.renovar', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    bootbox.confirm("Tem certeza que deseja renovar esse emprestimo?", function (result) {
        if (result) {
            window.open(url, '_blank');
            location.reload();
            //location.href = url
        } else {
            false;
        }
    });
});

$(document).on('click', 'a.baixa-pagamento', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    bootbox.confirm("Tem certeza que deseja dar baixa no pagamento desse empréstimo?", function (result) {
        if (result) {
            //window.open(url, '_blank');
            //location.reload();
            location.href = url
        } else {
            false;
        }
    });
});


// Scrip para devolução na aba por aluno
$(document).ready(function () {

    function formatAluno(d) {

        var exemplar = d['exemplares'];

        var html = "<table class='table table-bordered'>";
        html += "<thead>" +
            "<tr><td>Código do empréstimo</td><td>Título</td><td>Subtitulo</td><td>Número de chamada</td><td>Tombo</td><td>Data</td><td>Data devolução</td></tr>" +
            "</thead>";

        for (var i = 0; i < exemplar.length; i++) {
            html += "<tr>";
            html += "<td>" + exemplar[i]['codigo'] + "</td>";
            html += "<td>" + exemplar[i]['titulo'] + "</td>";
            html += "<td>" + exemplar[i]['subtitulo'] + "</td>";
            html += "<td>" + exemplar[i]['numero_chamada'] + "</td>";
            html += "<td>" + exemplar[i]['tombo'] + "</td>";
            html += "<td>" + exemplar[i]['data'] + "</td>";
            html += "<td>" + exemplar[i]['data_devolucao'] + "</td>";
            html += "</tr>"
        }
        html += "</table>";

        return html;
    }

    var table_aluno = $('#aluno-grid').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false,
        order: [[1, "asc"]],
        ajax: {
            url: "/index.php/seracademico/biblioteca/devolucaoEmprestimoPorAluno",
            data: function (d) {
                d.globalSearchAluno = $('input[name=globalSearchAluno]').val();
            }
        },
        columns: [
            {
                "className": 'details-control',
                "orderable": false,
                "data": 'pessoas.nome',
                "defaultContent": ''
            },
            {data: 'nome', name: 'pessoas.nome'},
            {data: 'identidade', name: 'pessoas.identidade'},
            {data: 'cpf', name: 'pessoas.cpf'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Função do submit do search da grid principal
    $('#search-form-aluno').on('submit', function (e) {
        table_aluno.draw();
        e.preventDefault();
    });

    // Add event listener for opening and closing details
    $('#aluno-grid tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_aluno.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(formatAluno(row.data())).show();
            tr.addClass('shown');
        }
    });
});

$(document).on('click', 'a.devolver-aluno', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    bootbox.confirm("Tem certeza que deseja devolver esse emprestimo?", function (result) {
        if (result) {
            window.open(url, '_blank');
            location.reload();
            //location.href = url
        } else {
            false;
        }
    });
});

$(document).on('click', 'a.baixa-pagamento-aluno', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    bootbox.confirm("Tem certeza que deseja dar baixa no pagamento desse empréstimo?", function (result) {
        if (result) {
            //window.open(url, '_blank');
            //location.reload();
            location.href = url
        } else {
            false;
        }
    });
});
