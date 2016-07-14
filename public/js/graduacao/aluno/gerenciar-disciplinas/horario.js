// Variável que armazenará a table de horário
var tableGerenciarDisciplinasHorario;

// Função para carregar a grid
function loadtableGerenciarDisciplinasHorario (idAluno, idSemestre) {
    tableGerenciarDisciplinasHorario = $('#gerenciardisciplinas-horario-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: "/index.php/seracademico/graduacao/aluno/semestre/gridHorario/"  + idAluno + "/" + idSemestre,
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

    //Retorno
    return tableGerenciarDisciplinasHorario;
}

// Função para o collapase
function beforeCollapse(treeId, treeNode) {
    return (treeNode.collapse !== false);
}

// Evento para adicionar horário ao aluno
function onDblClick(event, treeId, treeNode) {
    if(treeNode.id && idAluno) {
        swal({
                title: "Deseja realmente adicionar esses horários ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, desejo adicionar!",
                closeOnConfirm: false
            },
            function() {
                // Array de envio ajax
                var dados = {
                    'idAluno' : idAluno,
                    'idTurmaDisciplina' : treeNode.id,
                    'idDisciplina' : treeNode.idDisciplina
                };
               
                // Fazendo a requisição ajax
                jQuery.ajax({
                    type: 'POST',
                    data: dados,
                    url: '/index.php/seracademico/graduacao/aluno/semestre/adicionarHorarioAluno/' + idSemestre,
                    datatype: 'json'
                }).done(function (retorno) {
                    if(retorno.success) {
                        builderDisciplinasAlunoSemestre(idAluno, idSemestre);
                        loadTreeList(idAluno, idSemestre);
                        tableDisciplina.ajax.reload();
                        tableGerenciarDisciplinasHorario.ajax.reload();
                        tableHorario.ajax.reload();
                        tableNotas.ajax.reload();
                        tableFaltas.ajax.reload();
                        swal("Adicionado!", "Horaŕios adiciondos com sucesso.", "success");
                    } else {
                        swal("Ops! Ocorreu um problema!", retorno.msg, "error");
                    }
                });
            }
        );
    }
}

// evento para remover horários
$(document).on('click', '#btnRemoverHorario', function (event) {
    // Recuperando o id da disciplina
    var disciplina = $('#selRemoverHorario').find('option:selected').val();

    // Verificando a seleção da disciplina
    if (!disciplina) {
        swal("Você deve selecionar uma disciplina!", "", "error");
        event.preventDefault();
    }

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: {'idAluno' : idAluno, 'idSemestre' : idSemestre, 'idDisciplina' : disciplina},
        url: '/index.php/seracademico/graduacao/aluno/semestre/removerHorario',
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            builderDisciplinasAlunoSemestre(idAluno, idSemestre);
            loadTreeList(idAluno, idSemestre);
            tableDisciplina.ajax.reload();
            tableGerenciarDisciplinasHorario.ajax.reload();
            tableHorario.ajax.reload();
            tableNotas.ajax.reload();
            tableFaltas.ajax.reload();            

            swal("Horário removido com sucesso", "", "success");
        } else {
            swal("Ops! Ocorreu um problema!", retorno.msg, "error");
        }
    });
});


