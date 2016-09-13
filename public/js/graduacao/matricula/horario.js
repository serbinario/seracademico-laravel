// Variável que armazenará a table de horário
var tableHorario;

// Função para carregar a grid
function loadTableHorario (idAluno) {
    tableHorario = $('#horario-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        bPaginate: false,
        ajax: "/index.php/seracademico/matricula/gridHorario/" + idAluno,
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
    return tableHorario;
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

                // Requisição de confirmação caso for junção de turmas
                jQuery.ajax({
                    type: 'GET',
                    url: '/index.php/seracademico/matricula/validarPreRequisito',
                    data: dados,
                    datatype: 'json'
                }).done(function (retorno) {
                    if(retorno.success) {
                        // Mensagem do alerta
                        var msg = "Essa disciplina possui pré-requisitos que o aluno não concluio!";

                        // Alerta para caso de junção de turma
                        swal({
                                title: "Deseja realmente continuar ?",
                                text: msg,
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Sim, desejo continuar!",
                                closeOnConfirm: false
                            },
                            function() {
                                // Requisição de cadastro
                                adicionarHorarioAluno(dados);
                            });
                    } else {
                        // Requisição de cadastro
                        adicionarHorarioAluno(dados)
                    }
                });


            }
        );
    }
}

/**
 * Função responsável pela requisição
 * de adicionar horários
 *
 * @param daods
 */
function adicionarHorarioAluno(dados) {
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: dados,
        url: '/index.php/seracademico/matricula/adicionarHorarioAluno',
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            builderDisciplinasAlunoSemestre(idAluno, idSemestre);
            tableDisciplina.ajax.reload();
            tableHorario.ajax.reload();
            swal("Adicionado!", "Horaŕios adiciondos com sucesso.", "success");
        } else {
            swal("Ops! Ocorreu um problema!", retorno.msg, "error");
        }
    });
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
        url: '/index.php/seracademico/matricula/removerHorario',
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            tableHorario.ajax.reload();
            tableDisciplina.ajax.reload();
            builderDisciplinasAlunoSemestre(idAluno, idSemestre);

            swal("Horário removido com sucesso", "", "success");
        } else {
            swal("Ops! Ocorreu um problema!", retorno.msg, "error");
        }
    });
});


