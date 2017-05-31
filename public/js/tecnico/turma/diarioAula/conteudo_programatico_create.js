// Inicializando a grid de taxas do benefício
var tableConteudoProgramaticoDiarioAulaCreate = $('#conteudo-programatico-diario-aula-grid').DataTable({
    iDisplayLength: 5,
    bLengthChange: false,
    bFilter: false,
    autoWidth: false,
    columnDefs: [
        {
            "targets": [0],
            "visible": false,
            "searchable": false
        }
    ]
});

// Evento para adicionar linhas para grid de taxas
$('#btnAddConteudoProgramaticoDiarioAula').on( 'click', function () {
    // Recuperando o id da taxa
    var conteudo = $('#conteudo_programatico_diario_aula').val();

    if (!conteudo) {
        swal('Você deve escolher um conteúdo!', "Click no botão abaixo!", 'error');
        return false;
    }

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/tecnico/turma/diarioAula/getConteudosProgramaticos',
        data: {'conteudos' : [conteudo]},
        datatype: 'json'
    }).done(function (retorno) {
        // Removendo a seleção do select
        //$('#taxa_id_beneficios option').attr('selected', false);
        $("#conteudo_programatico_diario_aula").select2("val", "");

        // Percorrendo o array de retorno
        $.each(retorno.data, function (index, value) {
            tableConteudoProgramaticoDiarioAulaCreate.row.add(
                [
                    value.id,
                    value.nome,
                    '<a class="btn-floating" id="btnDeleteConteudoProgramaticoDiarioAula" title="Contrato"><i class="material-icons">delete</i></a>'
                ]
            ).draw( false );

            // escondendo o option
            //$('#taxa_id_beneficios option[value='+  value.id + ']').hide();
        });
    });
} );

// Removendo a linha da grid
$(document).on( 'click', '#btnDeleteConteudoProgramaticoDiarioAula', function () {
    // Recuperando o id od registro
    //var id = TableTaxasOfBeneficio.row($(this).parent().parent()).data()[0];

    // Exibindo a option do select
    // $('#taxa_id_beneficios option[value='+  id + ']').show();

    //Removendo a seleção
    $("#conteudo_programatico_diario_aula").select2("val", "");

    // Removendo a linha da grid
    tableConteudoProgramaticoDiarioAulaCreate
        .row( $(this).parents('tr') )
        .remove()
        .draw();
} );