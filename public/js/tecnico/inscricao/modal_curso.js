// Função para carregar a grid
var tableCurso;
function loadTableCurso (idInscricao) {
    tableCurso = $('#curso-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: "/index.php/seracademico/tecnico/inscricao/curso/grid/" + idInscricao,
        columns: [
            {data: 'codigo', name: 'fac_cursos.codigo'},
            {data: 'nome', name: 'fac_cursos.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableCurso;
}


//Id da turma selecionada na grid de disciplina
var idInscricaoCurso;
var idCurso;

//evento quando clicar na linha da grid de disciplinas
$(document).on('click', '#curso-grid tbody tr', function () {
    // Verificando se existe linhas na tabela
    if (tableCurso.rows().data().length > 0) {
        $(this).parent().find("tr td").removeClass('row_selected');
        $(this).find("td").addClass("row_selected");

        //Ativando o botão de adicionar materia e turno
        $("#btnAdicionarCursoTurno").attr("disabled", false);

        //Recuperando o id da turma selecionada e o index da linha selecionada
        idInscricaoCurso     = tableCurso.row($(this).index()).data().id;
        indexRowSelectedCurso = $(this).index();
        idCurso               = tableCurso.row($(this).index()).data().idCurso;
        console.log(indexRowSelectedCurso);
        // Executando a grid de materia e turno
        runTableTurno(idInscricaoCurso);
    }
});


// Função para executar a grid
function runTableCurso(idInscricao) {
    if (tableCurso) {
        tableCurso.ajax.url( "/index.php/seracademico/tecnico/inscricao/curso/grid/" + idInscricao).load();
    }

    loadTableCurso(idInscricao);
}

// Select2 para curso
$('#select_curso').select2({
    placeholder: 'Selecione',
    width: 300,
    allowClear: true,
    ajax: {
        type: 'POST',
        url: "/index.php/seracademico/util/select2",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search':         params.term, // search term
                'tableName':      'fac_cursos',
                'fieldName':      'nome',
                'fieldWhere':     'tipo_nivel_sistema_id',
                'valueWhere':     '4',
                'page':           params.page || 1,
                'tableNotIn':     'pos_inscricoes_cursos',
                'culmnNotGet':    'curso_id',
                'columnWhere':    'incricao_id',
                'valueNotWhere':   idInscricao,
                'columnNotWhere': 'id'
            };
        },
        headers: {
            'X-CSRF-TOKEN' : '{{  csrf_token() }}'
        },
        processResults: function (data, params) {

            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.data,
                pagination: {
                    more: data.more
                }
            };
        }
    }
});

// evento para incluir cursos
$(document).on('click', '#btnIncluirCursos', function () {
    // Recuperando os options selecionados
    var options = $('#select_curso').find('option:selected');

    // Validando o select do curso
    if($(options).length == 0) {
        swal("Você deve selecionar um curso!", "Click no botão abaixo!", "warning");
        return false;
    }

    // Variável para armazenar id de cursos
    var arrayCursoId = [];

    // Percorrendo todos os options selecionados
    $.each(options, function (index, value) {
       arrayCursoId[index] = $(value).val();
    });

    // Dados para requisição ajax
    var dadosAjax    = {
        'arrayCursoId' : arrayCursoId,
        'idInscricao' : idInscricao
    };

    // Requisição ajax
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/tecnico/inscricao/curso/store',
        data: dadosAjax,
        datatype: 'json'
    }).done(function (retorno) {
        swal(retorno.msg, "Click no botão abaixo!", "success");
        tableCurso.ajax.reload();
        table.ajax.reload();
        $("#select_curso").select2("val", "");
    });
});

// Evento para o click no botão de remover curso do vestibular
$(document).on('click', '#removerCurso', function () {
    var idCurso = tableCurso.row($(this).parent().parent().index()).data().idCurso;

    var dadosAjax    = {
        'idCurso' : idCurso,
        'idInscricao' : idInscricao
    };

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/seracademico/tecnico/inscricao/curso/delete',
        data: dadosAjax,
        datatype: 'json'
    }).done(function (retorno) {
        swal(retorno.msg, "Click no botão abaixo!", "success");
        $("#btnAdicionarCursoTurno").attr("disabled", true);
        tableCurso.ajax.reload();
        table.ajax.reload();
    });
});