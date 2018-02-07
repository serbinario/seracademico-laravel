// Função para carregar a grid
var tableDisciplina;
function loadTableDisciplina (idCurriculo) {
    /*Datatable da grid Modal*/
    tableDisciplina = $('#disciplina-grid').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        ajax: "/index.php/seracademico/tecnico/curriculo/gridByCurriculo/" + idCurriculo,
        columns: [
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
            {data: 'qtd_falta', name: 'fac_disciplinas.qtd_falta'},
            {data: 'tipo_disciplina', name: 'fac_tipo_disciplinas.nome'},
            {data: 'modulo', name: 'tec_modulos.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableDisciplina;
}


//Id da turma selecionada na grid de disciplina
var idDisciplina;

// Função para executar a grid
function runTableDisciplinas(idCurriculo) {
    if (tableDisciplina) {
        tableDisciplina.ajax.url( "/index.php/seracademico/tecnico/curriculo/gridByCurriculo/" + idCurriculo).load();
    }

    loadTableDisciplina(idCurriculo);
}

//consulta via select2
$("#select-disciplina").select2({
    placeholder: 'Selecione uma ou mais disciplinas',
    width: 600,
    ajax: {
        type: 'POST',
        url: "/index.php/seracademico/util/select2",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search':         params.term, // search term
                'tableName':      'fac_disciplinas',
                'fieldName':      'nome',
                'page':           params.page || 1,
                'tableNotIn':     'fac_curriculo_disciplina',
                'columnWhere' :   'curriculo_id',
                'columnNotWhere': 'id',
                'culmnNotGet':    'disciplina_id',
                'valueWhere':     4,
                'fieldWhere':     'tipo_nivel_sistema_id',
                'valueNotWhere':    idCurriculo
            };
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

//Evento do click no botão adicionar disciplina
$(document).on('click', '#addDisciplina', function (event) {
    var array   = $('#select-disciplina').select2('data');
    var modulo  = $('#modulo_id').val();

    // Verificando preenchimento dos campos disciplina e modulo
    if (!array.length > 0 || modulo == 0) {
        sweetAlert("Oops...", "Por favor, selecione a disciplina e um modulo", "error");
        return false;
    }

    var arrayId = [];

    for (var i = 0; i < array.length; i++) {
        arrayId[i] = array[i].id
    }

    //Setando o o json para envio
    var dados = {
        'idCurriculo' : idCurriculo,
        'idDisciplinas' : arrayId,
        'modulo_id' : modulo
    };

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/seracademico/tecnico/curriculo/adicionarDisciplinas",
        data: dados,
        datatype: 'json'
}).done(function (json) {
        $('#select-disciplina').select2("val", "");
        swal("Disciplina(s) adicionada(s) com sucesso!", "Click no botão abaixo!", "success");
        tableDisciplina.ajax.reload();
    });
});

//Evento de remover a disciplina
$(document).on('click', '.removerDisciplina', function () {
    idDisciplina = tableDisciplina.row($(this).parent().parent().parent().parent().parent().index()).data().id;

    //Setando o o json para envio  04848387418
    var dados = {
        'idCurriculo'  : idCurriculo,
        'idDisciplina' : idDisciplina
    };

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/seracademico/tecnico/curriculo/removerDisciplina",
        data: dados,
        datatype: 'json'
}).done(function (retorno) {
        $('#select-disciplina').select2("val", "");
        swal("Disciplina removida com sucesso!", "Click no botão abaixo!", "success");
        tableDisciplina.ajax.reload();
    });
});