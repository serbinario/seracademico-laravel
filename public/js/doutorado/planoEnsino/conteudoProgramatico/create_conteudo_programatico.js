// Evento para adicionar linhas para grid de taxas
$('#btnCreateConteudo').on( 'click', function () {
    // Recuperando o valor do conteúdo
    var conteudo = $('#conteudo_programatico').val();

    // Verificando se foi passado valor válido
    if (!conteudo) {
        swal('Você deve criar um conteúdo!', "Click no botão abaixo!", 'error');
        return false;
    }

    // Limpando o campo de conteúdo
    $("#conteudo_programatico").val("");

    // Adicionando a linha na tabela
    tableConteudoProgramatico.row.add(
        [
            conteudo,
            '<a class="btn-floating" id="btnRemoverConteudo" title="Contrato"><i class="material-icons">delete</i></a>'
        ]
    ).draw( false );
} );

// Removendo a linha da grid
$(document).on( 'click', '#btnRemoverConteudo', function () {
    // Removendo a linha da grid
    tableConteudoProgramatico
        .row( $(this).parents('tr') )
        .remove()
        .draw();
} );

// evento para interromper a submissão
$('#formPlanoEnsino').submit(function (event) {
    // Variável quer armazenará os conteudos
    var conteudos = [];

    // Percorrendo todos os conteudos
    $.each(tableConteudoProgramatico.rows().data(),function (index, valor) {
        conteudos[index] = valor[0];
    });

    // Adicionando na requisição
    $("#conteudo_programatico").attr('name', 'conteudo_programatico').val(conteudos);
});