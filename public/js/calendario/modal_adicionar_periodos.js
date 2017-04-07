// Carregando a table
var tablePeriodos;
function loadTablePeriodos() {
    // Carregaando a grid
    tablePeriodos = $('#periodos-grid').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/indexk.php/calendarioAnual/gridPeriodo",
        columns: [
            {data: 'periodo', name: 'periodos.nome'},
            {data: 'data_inicial', name: 'periodos_avaliacao.data_inicial'},
            {data: 'data_final', name: 'periodos_avaliacao.data_final'},
            {data: 'dias_letivos', name: 'periodos_avaliacao.dias_letivos'},
            {data: 'semanas_letivas', name: 'periodos_avaliacao.semanas_letivas'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tablePeriodos;
}


// Função de execução
function runModalAdicionarPeriodos(idCalendario)
{
    /*//Carregando as grids de situações
    if(tablePeriodos) {
        loadTablePeriodos(idCalendario).ajax.url('calendario.gridPeriodo', {'id' :idCalendario }).load();
    } else {
        loadTablePeriodos(idCalendario);
    }
    
    // Carregando os selects
    periodos("");

    // Desabilitando o botão de editar
    $('#edtPeriodo').prop('disabled', true);
    $('#edtPeriodo').hide();

    // Exibindo o modal
    $('#modal-adicionar-periodos').modal({'show' : true});*/
}

// Id do periodo
var idPeriodo;


//Evento do click no botão adicionar período
$(document).on('click', '#addPeriodo', function (event) {

    //Recuperando os valores dos campos do fomulário
    var periodo         = $('#periodo').val();
    var dtInicial       = $('#dtInicial').val();
    var dtFinal         = $('#dtFinal').val();
    var diasLetivos     = $('#diasLetivos').val();
    var semanasLetivas  = $('#semanasLetivas').val();
    
    // Verificando se os campos de preenchimento obrigatório foram preenchidos
    if (!periodo || !dtInicial || !dtFinal ) {
        swal("Oops...", "Você deve selecionar um período e informar data inicial e final!", "error");
        return false;
    }

    //Setando o o json para envio
    var dados = {
        'calendarios_id' : idCalendario,
        'periodos_id' : periodo,
        'data_inicial' : dtInicial,
        'data_final' : dtFinal,
        'dias_letivos' : diasLetivos,
        'semanas_letivas' : semanasLetivas
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: ('calendario.storePeriodo'),
        data: dados,
        datatype: 'json'
    }).done(function (json) {
        swal("Período(s) adicionada(s) com sucesso!", "Click no botão abaixo!", "success");
        tablePeriodos.ajax.reload();
        table.ajax.reload();

        // Limpar os campos do formulário
        limparCamposFormulario();
    });
});

// Evento para editar o evento letivos
$(document).on("click", "#editarPeriodo", function () {
    //Recuperando o id do evento
    idPeriodo = tablePeriodos.row($(this).parents('tr')).data().id;

    // Recuperando os dados do evento
    var periodo         = tablePeriodos.row($(this).parents('tr')).data().periodo_id;
    var dataInicial     = tablePeriodos.row($(this).parents('tr')).data().data_inicial;
    var diaFinal        = tablePeriodos.row($(this).parents('tr')).data().data_final;
    var dLetivo         = tablePeriodos.row($(this).parents('tr')).data().dias_letivos;
    var sLetivo         = tablePeriodos.row($(this).parents('tr')).data().semanas_letivas;
    var totalDia        = tablePeriodos.row($(this).parents('tr')).data().total_dias;
    var totalSemana     = tablePeriodos.row($(this).parents('tr')).data().total_semanas;

    // prenchendo o os campos de evento
    periodos(periodo);
    $('#dtInicial').val(dataInicial);
    $('#dtFinal').val(diaFinal);
    $('#diasLetivos').val(dLetivo);
    $('#semanasLetivas').val(sLetivo);
    $('#totalDias').val(totalDia);
    $('#totalSemanas').val(totalSemana);

    // Desabilitando o botão de editar
    $('#edtPeriodo').prop('disabled', false);
    $('#edtPeriodo').show();
    $('#addPeriodo').hide();

});

//Evento do click no botão adicionar período
$(document).on('click', '#edtPeriodo', function (event) {

    //Recuperando os valores dos campos do fomulário
    var periodo         = $('#periodo').val();
    var dtInicial       = $('#dtInicial').val();
    var dtFinal         = $('#dtFinal').val();
    var diasLetivos     = $('#diasLetivos').val();
    var semanasLetivas  = $('#semanasLetivas').val();

    // Verificando se os campos de preenchimento obrigatório foram preenchidos
    if (!periodo || !dtInicial || !dtFinal ) {
        swal("Oops...", "Você deve selecionar um período e informar data inicial e final!", "error");
        return false;
    }

    //Setando o o json para envio
    var dados = {
        'calendarios_id' : idCalendario,
        'periodos_id' : periodo,
        'data_inicial' : dtInicial,
        'data_final' : dtFinal,
        'dias_letivos' : diasLetivos,
        'semanas_letivas' : semanasLetivas
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: ('calendario.updatePeriodo', {'id' : idPeriodo}),
        data: dados,
        datatype: 'json'
    }).done(function (json) {
        swal("Período(s) adicionada(s) com sucesso!", "Click no botão abaixo!", "success");
        tablePeriodos.ajax.reload();
        table.ajax.reload();

        // Limpar os campos do formulário
        limparCamposFormulario();

        // Desabilitando o botão de editar
        $('#addPeriodo').prop('disabled', false);
        $('#addPeriodo').show();
        $('#edtPeriodo').hide();
    });
});

//Evento de remover a evento não letivos
$(document).on('click', '#deletePeriodo', function () {

    var idPeriodoAV = tablePeriodos.row($(this).parents('tr').index()).data().id;

    //Setando o o json para envio
    var dados = {
        'idPeriodo' : idPeriodoAV
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: ('calendario.removerPeriodo', {'id' : idPeriodoAV}),
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        swal("Período removido com sucesso!", "Click no botão abaixo!", "success");
        tablePeriodos.ajax.reload();
        table.ajax.reload();
    });
});

//Evento para validar data inicial conforme o período do calendário
$(document).on('change', '#dtInicial', function () {
    
    // Recuperando o valor da data inicial
    var data = $('#dtInicial').val();
    
    // Retorna a reposta da validação da data
    validarDatas(data);

});

//Evento para validar data final conforme o período do calendário
$(document).on('change', '#dtFinal', function () {

    // Recuperando o valor da data inicial
    var data = $('#dtFinal').val();

    // Retorna a reposta da validação da data
    validarDatas(data);

});

// Função para validar se as datas estão dentro do período do calendário
function validarDatas(data) {
    
    //Setando o o json para envio
    var dados = {
        'idCalendario' : idCalendario,
        'data' : data
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: ('calendario.validarDataCalendario'),
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {

        // Exibi mensagem de falha na validação da data
        if(retorno == 0) {

            // Desabilitando o botão de editar e adicionar
            $('#edtPeriodo').prop('disabled', true);
            $('#addPeriodo').prop('disabled', true);

            swal("Oops...", "A data informada não está dentro do período informado no calendário!", "error");
        } else {
            $('#edtPeriodo').prop('disabled', false);
            $('#addPeriodo').prop('disabled', false);
        }
    });
}

//Limpar os campos do formulário
function limparCamposFormulario()
{
    periodos("");
    $('#periodo').val("");
    $('#dtInicial').val("");
    $('#dtFinal').val("");
    $('#diasLetivos').val("");
    $('#semanasLetivas').val("");
}

