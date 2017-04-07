// Carregando a table
var tableEventos;
function loadTableEventos() {
    // Carregaando a grid
    tableEventos = $('#eventos-grid').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: true,
        autoWidth: false,
        ajax: '/index.php/seracademico/calendarioAnual/gridEvento',
        columns: [
            {data: 'nome', name: 'feriados_eventos.nome'},
            {data: 'data_feriado', name: 'feriados_eventos.data_feriado'},
            {data: 'dia_semana', name: 'feriados_eventos.dia_semana'},
            {data: 'dia_letivo', name: 'dia_letivo.nome'},
            //{data: 'tipo_evento', name: 'tipo_evento.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableEventos;
}

// Função de execução
function runModalAdicionarEventos()
{
    //Carregando as grids de eventos
    if(tableEventos) {
        loadTableEventos().ajax.url('/index.php/seracademico/calendarioAnual/gridEvento').load();
    }

    loadTableEventos();

    // Exibindo o modal
    $('#modal-adicionar-eventos').modal({'show' : true});
}

//Evento do click no botão adicionar evento
$(document).on('click', '#addEvento', function(event) {
    //Recuperando os valores dos campos do fomulário
    var nome       = $('#nome').val();
    var dtFeriado  = $('#dtFeriado').val();
    var diaSemana  = $('#diaSemana').val();
    var diaLetivo  = $('#diaLetivo').val();
    
    // Verificando se os campos de preenchimento obrigatório foram preenchidos
    if (!nome || !dtFeriado || !diaLetivo) {
        swal("Oops...", "Há campos obrigatórios que não foram preenchidos!", "error");
        return false;
    }

    //Setando o o json para envio
    var dados = {
        'nome' : nome,
        'data_feriado' : dtFeriado,
        'dia_semana' : diaSemana,
        'dia_letivo_id' : diaLetivo
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: "/index.php/seracademico/calendarioAnual/storeEvento",
        data: dados,
        datatype: 'json'
    }).done(function (json) {
        swal("Evento adicionado com sucesso!", "Click no botão abaixo!", "success");
        tableEventos.ajax.reload();

        //Limpar os campos do formulário
        limparCamposEvento();
    });
});

//Evento de remover a evento letivos
$(document).on('click', '#deleteEvento', function () {

    //capturando o id do registro da linha
    var idEvento = tableEventos.row($(this).parents('tr').index()).data().id;

    // Requisição Ajax
    jQuery.ajax({
        type: 'get',
        url: "/index.php/seracademico/calendarioAnual/removerEvento/" + idEvento,
        //data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        swal("Disciplina removida com sucesso!", "Click no botão abaixo!", "success");
        tableEventos.ajax.reload();
        table.ajax.reload();
    });
});

//Evento para pegar o dia da semana da data de feriado informado
$(document).on('focusout', '#dtFeriado', function () {

    // Recuperando o valor da data inicial
    var data = $('#dtFeriado').val();

    //Setando o o json para envio
    var dados = {
        'data' : data
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: "/index.php/seracademico/calendarioAnual/getDiaSemana",
        data: dados,
        datatype: 'json'
    }).done(function (json) {

        $('#diaSemana').val(json.dados);

    });
});

//Limpar os campos do formulário
function limparCamposEvento()
{
    $('#nome').val("");
    $('#dtFeriado').val("");
    $('#diaSemana').val("");
}
