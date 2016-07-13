// Função para carregar as disciplinas do semestre do aluno
function builderDisciplinasAlunoSemestre(idAluno, idSemestre) {
    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: {'idAluno' : idAluno, 'idSemestre' : idSemestre},
        url: '/index.php/seracademico/matricula/getDisciplinas',
        datatype: 'json'
    }).done(function (retorno) {
        if(retorno.success) {
            // Html de retorno
            var html = '<option value="">Selecione uma disciplina</option>';

            // Percorrendo o retorno e criando as options
            $.each(retorno.data, function (index, value) {
                html += '<option value="'+ value.id +'">'+ value.nome +'</option>'
            });

            // Carregando o html
            $('#selRemoverHorario').html(html);
        } else {
            swal("Ops! Ocorreu um problema!", retorno.msg, "error");
        }
    });
}