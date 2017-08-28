/**
 * Created by Fabio Aguiar on 20/03/2017.
 */

// Exibir campos para seleção de exibição em campos no relatório
$(document).ready(function(){

    $('.campo-tabela').hide();

    // Exibi a mensagem de informação para caso da opção de "Deseja sigilo" esta marcada
    $('#tipo-relatorio-1, #tipo-relatorio-2').on('click', function(){
        if($("#tipo-relatorio-1").prop( "checked")) {
            $('.campo-tabela').show();
        } else if ($("#tipo-relatorio-2").prop( "checked")) {
            $('.campo-tabela').hide();
        }
    });

});

//Generico para os selects2
function formatRepo(repo) {
    if (repo.loading) return repo.text;

    var markup = '<option value="' + repo.id + '">' + repo.name + '</option>';
    return markup;
}

//Generico para os selects2
function formatRepoSelection(repo) {

    return repo.name || repo.text
}

//consulta via select2 responsável
$("#responsavel").select2({
    placeholder: 'Selecione um responsável',
    allowClear: true,
    minimumInputLength: 1,
    escapeMarkup: function (markup) {
        return markup;
    },
    templateResult: formatRepo,
    templateSelection: formatRepoSelection,
    width: 325,
    ajax: {
        type: 'POST',
        url: "/index.php/seracademico/util/select2personalizado",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search': params.term, // search term
                'tableName': 'responsaveis',
                'fieldName': 'nome',
                'page': params.page
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
                    more: (params.page * 30) < data.total_count
                }
            };
        }
    }
});

//consulta via select2 responsável
$("#outro_responsavel").select2({
    placeholder: 'Selecione um outro responsável',
    allowClear: true,
    minimumInputLength: 1,
    escapeMarkup: function (markup) {
        return markup;
    },
    templateResult: formatRepo,
    templateSelection: formatRepoSelection,
    width: 325,
    ajax: {
        type: 'POST',
        url: "/index.php/seracademico/util/select2personalizado",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search': params.term, // search term
                'tableName': 'responsaveis',
                'fieldName': 'nome',
                'page': params.page
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
                    more: (params.page * 30) < data.total_count
                }
            };
        }
    }
});
