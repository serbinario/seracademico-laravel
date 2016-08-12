// Evento para adicionar linhas para grid de taxas
$('#btnAddConteudoPlanoAula').on( 'click', function () {
    // Recuperando o valor do conteúdo
    var conteudo = $('#conteudo_plano_aula').val();

    // Verificando se foi passado valor válido
    if (!conteudo) {
        swal('Você deve criar um conteúdo!', "Click no botão abaixo!", 'error');
        return false;
    }

    // Requisição ajax
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/graduacao/planoEnsino/planoAula/getConteudosIn',
        data: {'conteudos' : [conteudo]},
        datatype: 'json'
    }).done(function (retorno) {
        // Removendo a seleção do select
        $("#conteudo_plano_aula option").attr("selected", false);

        // Percorrendo o array de retorno
        $.each(retorno.data, function (index, value) {
            // Adicionando a linha na tabela
            tableConteudoPlanoAula.row.add(
                [
                    value.id,
                    value.nome,
                    '<a class="btn-floating" id="btnDestroyConteudoPlanoAula" title="Contrato"><i class="material-icons">delete</i></a>'
                ]
            ).draw( false );

            // escondendo o option
            $('#conteudo_plano_aula option[value='+  value.id + ']').hide();
        });
    });
} );

// Removendo a linha da grid
$(document).on( 'click', '#btnDestroyConteudoPlanoAula', function () {
    // Recuperando o id od registro
    var id = tableConteudoPlanoAula.row($(this).parents('tr')).data()[0];

    // Exibindo a option do select
    $('#conteudo_plano_aula option[value='+  id + ']').show();

    // Removendo a linha da grid
    tableConteudoPlanoAula
        .row( $(this).parents('tr') )
        .remove()
        .draw();
} );