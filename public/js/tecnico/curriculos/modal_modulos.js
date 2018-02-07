// Função para carregar a grid
var tableModulos;
function loadTableModulo (idCurriculo) {
    /*Datatable da grid Modal*/
    tableModulos = $('#modulos-grid').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        ajax: "/index.php/seracademico/tecnico/modulo/grid/" + idCurriculo,
        columns: [
            {data: 'codigo', name: 'tec_modulos.codigo'},
            {data: 'nome', name: 'tec_modulos.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableModulos;
}


//Id da turma selecionada na grid de disciplina
var idModulo;

// Função para executar a grid
function runTableModulos(idCurriculo) {

    if (tableModulos) {
        tableModulos.ajax.url( "/index.php/seracademico/tecnico/modulo/grid/" + idCurriculo).load();
    }

    loadTableModulo(idCurriculo);

    $('#editModulo').hide();
}


//Evento do click no botão adicionar disciplina
$(document).on('click', '#addModulo', function (event) {
    var codigo = $('#codigo').val();
    var nome = $('#nome').val();

    // Verificando preenchimento dos campos disciplina e modulo
    if (!codigo && !nome) {
        sweetAlert("Oops...", "Por favor, informe código e nome", "error");
        return false;
    }

    //Setando o o json para envio
    var dados = {
        'curriculo_id': idCurriculo,
        'codigo': codigo,
        'nome': nome
    };

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/seracademico/tecnico/modulo/store",
        data: dados,
        datatype: 'json'
    }).done(function (json) {

        if (json['success']) {
            swal("Módulo adicionado com sucesso!", "Click no botão abaixo!", "success");
        } else {
            swal(json['msg'], "Click no botão abaixo!", "success");
        }

        tableModulos.ajax.reload();
        table.ajax.reload();

    });
});

//Evento de remover a disciplina
$(document).on('click', '.editar-modulo', function () {

    idModulo = tableModulos.row($(this).parent().parent().parent().parent().parent().index()).data().id;

    jQuery.ajax({
        type: 'GET',
        url: "/index.php/seracademico/tecnico/modulo/edit/" + idModulo,
        datatype: 'json'
    }).done(function (retorno) {

        if(retorno['success']) {
            $('#codigo').val(retorno['content']['codigo']);
            $('#nome').val(retorno['content']['nome']);

            $('#editModulo').show();
            $('#addModulo').hide();
        } else {
            swal(retorno['content'], "Click no botão abaixo!", "success");
        }

    });
});

//Evento do click no botão adicionar disciplina
$(document).on('click', '#editModulo', function (event) {
    var codigo = $('#codigo').val();
    var nome = $('#nome').val();

    // Verificando preenchimento dos campos disciplina e modulo
    if (!codigo && !nome) {
        sweetAlert("Oops...", "Por favor, informe código e nome", "error");
        return false;
    }

    //Setando o o json para envio
    var dados = {
        'curriculo_id': idCurriculo,
        'codigo': codigo,
        'nome': nome
    };

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/seracademico/tecnico/modulo/update/" + idModulo,
        data: dados,
        datatype: 'json'
    }).done(function (json) {

        if (json['success']) {
            swal("Módulo editado com sucesso!", "Click no botão abaixo!", "success");

            $('#editModulo').hide();
            $('#addModulo').show();
        } else {
            swal(json['msg'], "Click no botão abaixo!", "success");
        }

        tableModulos.ajax.reload();
        table.ajax.reload();

    });
});

//Evento de remover a disciplina
$(document).on('click', '.delete-modulo', function () {
    idModulo = tableModulos.row($(this).parent().parent().parent().parent().parent().index()).data().id;

    jQuery.ajax({
        type: 'GET',
        url: "/index.php/seracademico/tecnico/modulo/delete/" + idModulo,
        datatype: 'json'
}).done(function (retorno) {
        if(retorno['msg']) {
            swal("Módulo removida com sucesso!", "Click no botão abaixo!", "success");
        } else {
            swal(retorno['msg'], "Click no botão abaixo!", "success");
        }
        tableModulos.ajax.reload();
        table.ajax.reload();
    });
});