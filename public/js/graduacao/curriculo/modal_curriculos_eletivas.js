// Função para carregar a grid
var tableDisciplinaEletiva;
function loadTableDisciplinaEletiva (idCurriculo) {
    tableDisciplinaEletiva = $('#disciplina-eletiva-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/graduacao/curriculo/eletiva/grid/" + idCurriculo,
        columns: [
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'periodo', name: 'fac_curriculo_disciplina.periodo'},
        ]
    });

    return tableDisciplinaEletiva;
}

//Grid opções de eletivas
var tableOpcoesEletivas;
function runTableOpcoesEletivas (idCurriculoDisciplinaEletiva) {
    tableOpcoesEletivas = $('#opcoes-eletivas-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/graduacao/curriculo/eletiva/gridOpcoesEletivas/" + idCurriculoDisciplinaEletiva,
        columns: [
            {data: 'semestre', name: 'fac_semestres.nome'},
            {data: 'disciplina', name: 'fac_disciplina.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableOpcoesEletivas;
}

//Id da turma selecionada na grid de disciplina
var idCurriculoDisciplinaEletiva, indexRowSelectedDisciplinaEletiva;

//evento quando clicar na linha da grid de disciplinas
$(document).on('click', '#disciplina-eletiva-grid tbody tr', function () {
    // Verificando se existe linhas na tabela
    if (tableDisciplinaEletiva.rows().data().length > 0) {
        $(this).parent().find("tr td").removeClass('column_selected');
        $(this).find("td").addClass("column_selected");

        //Ativando o botão de adicionar disciplina
        $("#btnAdicionarOpcaoEletiva").prop("disabled", false);

        //Recuperando o id da turma selecionada e o index da linha selecionada
        idCurriculoDisciplinaEletiva = tableDisciplinaEletiva.row($(this).index()).data().id;
        indexRowSelectedDisciplinaEletiva =  $(this).index();

        // Executando a grid de opcoes de eletivas
        if(!tableOpcoesEletivas) {
            runTableOpcoesEletivas(idCurriculoDisciplinaEletiva);
        } else {
            runTableOpcoesEletivas(idCurriculoDisciplinaEletiva).ajax.url( "/index.php/seracademico/graduacao/curriculo/eletiva/gridOpcoesEletivas/" + idCurriculoDisciplinaEletiva).load();
        }
    }
});


// Função para executar a grid
function runTableDisciplinaEletiva(idCurriculo) {
    if (tableDisciplinaEletiva) {
        loadTableDisciplinaEletiva(idCurriculo).ajax.url("/index.php/seracademico/graduacao/curriculo/eletiva/grid/" + idCurriculo).load();
    }

    loadTableDisciplinaEletiva(idCurriculo);
}