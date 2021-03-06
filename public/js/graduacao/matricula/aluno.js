// id do aluno clicado e o semestre
var idAluno, idSemestre;

// desabilitando a configuração de erro padrão
$.fn.dataTable.ext.errMode = 'none';

// Tabela de alunos
var tableAluno = $('#aluno-grid').DataTable({
    processing: true,
    serverSide: true,
    autoWidth: false,
    ajax: "/index.php/seracademico/matricula/gridAluno/",
    columns: [
        {data: 'nome', name: 'pessoas.nome'},
        {data: 'matricula', name: 'fac_alunos.matricula'},
        {data: 'celular', name: 'pessoas.celular'},
        {data: 'cpf', name: 'pessoas.cpf'},
        {data: 'codCurso', name: 'fac_cursos.codigo'},
        {data: 'codCurriculo', name: 'fac_curriculos.codigo'},
        {data: 'periodo', name: 'fac_alunos_semestres.periodo'},
        {data: 'nomeTurno', name: 'fac_turnos.nome'},
        {data: 'nomeSituacao', name: 'fac_situacao.nome'}
    ]
});

// evento para tratamento de erro
tableAluno.on( 'error.dt', function(e, settings, techNote, message) {
    swal('Semestre não encontrado, verifique o item "Semestre vigente" no parâmetro "Matrícula" em configurações.', "Click no botão abaixo!", "error");
});


// Evento para quando clicar na grid de aluno
$(document).on('click', '#aluno-grid tbody tr', function () {
    // Verificando se é uma linha válida
    if(tableAluno.row($(this).index()).data()) {
        // Aplicando o estilo css
        $(this).parent().find("tr td").removeClass('row_selected');
        $(this).find("td").addClass("row_selected");

        // Recuperando o id do aluno selecionado e o semestre
        idAluno    = tableAluno.row($(this).index()).data().id;
        idSemestre = tableAluno.row($(this).index()).data().idSemestre;

        // Verificando se a tabela já foi carregada
        if(!tableDisciplina) {
            loadTableDisciplina(idAluno);
        } else {
            // Recarregando a tableDisciplina
            tableDisciplina.ajax.url("/index.php/seracademico/matricula/gridDisciplina/" + idAluno).load(function ( data ) {
                if(data.data.length == 0) {
                    $('#nomeCurso').text("Nenhuma disciplina foi encontrada para esse aluno.");
                } else {
                    $('#nomeCurso').text(data.data[0].nomeAluno + ' - ' +data.data[0].nomeCurso);
                }
            });
        }

        // Verificando se a tabela já foi carregada
        if(!tableHorario) {
            loadTableHorario(idAluno);
        } else {
            // Recarregando a tableHorario
            tableHorario.ajax.url("/index.php/seracademico/matricula/gridHorario/" + idAluno).load();
        }

        // Carregando as opções de remoção de horários
        builderDisciplinasAlunoSemestre(idAluno, idSemestre);

        // Tratamento das abas
        $("#nav-tab li").removeClass('active');
        $("#nav-tab li#li-disciplinas").addClass('active');

        $("#turmas").removeClass('active');
        $("#alunos").removeClass('active');
        $("#disciplinas").addClass('active');
    }
});
