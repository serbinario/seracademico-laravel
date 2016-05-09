// Função para carregar a grid
var tableHorario;
function loadTableHorario (idTurma) {
    tableHorario = $('#horario-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: "/index.php/seracademico/graduacao/turma/horario/grid/" + idTurma,
        columns: [
            {data: 'codigoHora', name: 'fac_horas.nome', orderable: false, searchable: false},
            {data: 'domingo', name: 'domingo', orderable: false, searchable: false},
            {data: 'segunda', name: 'segunda', orderable: false, searchable: false},
            {data: 'terca', name: 'terca', orderable: false, searchable: false},
            {data: 'quarta', name: 'quarta', orderable: false, searchable: false},
            {data: 'quinta', name: 'quinta', orderable: false, searchable: false},
            {data: 'sexta', name: 'sexta', orderable: false, searchable: false},
            {data: 'sabado', name: 'sabado', orderable: false, searchable: false}
        ]
    });

    return tableHorario;
}

// Função para executar a grid
function runTableHorario(idTurma) {
    if (tableHorario) {
        tableHorario.ajax.url( "/index.php/seracademico/graduacao/turma/horario/grid/" + idTurma).load();
    }

    loadTableHorario(idTurma);
}

// Variáveis úteis
var idHorario;
var idDisciplinaHorario;

// Evento quando clicar numa coluna
$(document).on('click', '#horario-grid tbody tr td', function () {
    // Removendo todos os css
    $(this).parent().parent().find('tr td').removeClass('column_selected');

    if($(this).text() != "" && $(this).index() != 0) {
        // Fazendo a lógica de seleção para o css
        //$(this).parent().parent().find('tr td').removeClass('column_selected');
        $(this).addClass('column_selected');

        // Recuperando os valores úteis
        idHora = tableHorario.row($(this).parent().index()).data().hora;
        idDia  = $(this).index();
    } else {
        idDisciplinaHorario = 0;
    }
});
