/**
 * Created by Fabio Aguiar on 16/01/2017.
 */

//Global idCalendario
var idCalendario;

// Evento para abrir o modal de períodos de avaliação
$(document).on("click", "#btnModalAdicionarPeriodo", function () {
    // Recuperando o id do calendário
    idCalendario = table.row($(this).parents('tr')).data().id;

    // Recuperando o nome e o código
    var ano = table.row($(this).parents('tr')).data().ano;
    var nome   = table.row($(this).parents('tr')).data().nome;

    // prenchendo o titulo do nome do aluno
    $('#cNome').text(nome);
    $('#cAno').text(ano);

    // Executando o modal
    runModalAdicionarPeriodos(idCalendario);
});


// Evento para abrir o modal de eventos
$(document).on("click", "#btnModalAdicionarEvento", function () {
    // Recuperando o id do calendário
    idCalendario = table.row($(this).parents('tr')).data().id;

    // Recuperando o nome e o código
    var ano = table.row($(this).parents('tr')).data().ano;
    var nome   = table.row($(this).parents('tr')).data().nome;

    // prenchendo o titulo do nome do aluno
    $('#eNome').text(nome);
    $('#eAno').text(ano);

    // Executando o modal
    runModalAdicionarEventos(idCalendario);
});