// Forçando o focus do modal
$.fn.modal.Constructor.prototype.enforceFocus = function() {};

//consulta via select2
$("#conteudo_programatico_diario_aula_edit").select2({
    placeholder: 'Selecione um conteúdo',
    //minimumInputLength: 3,
    width: 718,
    ajax: {
        type: 'POST',
        url: '/index.php/seracademico/util/diarioAula/editQuery',//"{{ route('seracademico.util.select2')  }}",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search':     params.term, // search term
                'tableName':  'fac_conteudos_programaticos',
                'displayfieldName':  'nome',
                'searchFieldsNames': ['nome'],
                'page':       params.page || 1,
                'idDiarioAula': idDiarioAula,
                'planoEnsinoId' : idPlanoEnsinoDiarioAula
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
        },
        cache: true
    }
});

// Função para retornar os ids dos conteudos na grid
function getConteudosProgramaticosId()
{
    // Verificando se a tabela foi inicializada
    if(!tableConteudoProgramaticoDiarioAulaCreate) {
        return false;
    }

    // Variável local que armazenará os ids dos conteudos
    var conteudos = [];

    // Carregando as taxas
    $.each(tableConteudoProgramaticoDiarioAulaCreate.rows().data(),function (index, val) {
        conteudos[index] = val[0];
    });

    // Retorno
    return  conteudos;
}

//consulta via select2
$("#conteudo_programatico_diario_aula").select2({
    placeholder: 'Selecione um conteúdo',
    //minimumInputLength: 3,
    width: 718,
    ajax: {
        type: 'POST',
        url: '/index.php/seracademico/util/diarioAula/createQuery',//"{{ route('seracademico.util.select2')  }}",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search':     params.term, // search term
                'tableName':  'fac_conteudos_programaticos',
                'displayfieldName':  'nome',
                'searchFieldsNames': ['nome'],
                'page':       params.page || 1,
                'conteudos' :  getConteudosProgramaticosId(),
                'planoEnsinoId' : idPlanoEnsinoDiarioAula
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
        },
        cache: true
    }
});

