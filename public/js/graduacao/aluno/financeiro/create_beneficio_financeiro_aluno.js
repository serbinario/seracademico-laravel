// Evento para adicionar linhas para grid de taxas
$('#btnAddBeneficio').on( 'click', function () {
    // Recuperando o valor do conteúdo
    var beneficio = $('#beneficio_id_debito').val();

    // Verificando se foi passado valor válido
    if (!beneficio) {
        swal('Você deve criar escolher um benefício!', "Click no botão abaixo!", 'error');
        return false;
    }

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/financeiro/aluno/beneficio/getIn',
        data: {'beneficios' : [beneficio]},
        datatype: 'json'
    }).done(function (retorno) {
        // Removendo a seleção do select
        $("#beneficio_id_debito option").attr("selected", false);

        // Percorrendo o array de retorno
        $.each(retorno.data, function (index, value) {
            // Adicionando a linha na tabela
            tableBeneficioDebitoAluno.row.add(
                [
                    value.id,
                    value.nome,
                    value.valor,
                    value.action
                ]
            ).draw( false );

            // escondendo o option
            $('#beneficio_id_debito option[value='+  value.id + ']').hide();
        });
    });
} );

// Removendo a linha da grid
$(document).on( 'click', '#btnDeleteBeneficio', function () {
    // Recuperando o id od registro
    var id = tableBeneficioDebitoAluno.row($(this).parents('tr')).data()[0];

    // Exibindo a option do select
    $('#beneficio_id_debito option[value='+  id + ']').show();

    // Removendo a linha da grid
    tableBeneficioDebitoAluno
        .row( $(this).parents('tr') )
        .remove()
        .draw();
} );