// Forçando o focus do modal
$.fn.modal.Constructor.prototype.enforceFocus = function() {};

//consulta via select2
$("#taxa_id_beneficios_editar").select2({
    placeholder: 'Selecione uma Taxa',
    allowClear: true,
    //minimumInputLength: 3,
    width: 718,
    ajax: {
        type: 'POST',
        url: '/index.php/seracademico/util/beneficio/editQuery',//"{{ route('seracademico.util.select2')  }}",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search':     params.term, // search term
                'tableName':  'fin_taxas',
                'displayfieldName':  'nome',
                'searchFieldsNames': ['nome', 'codigo'],
                'page':       params.page || 1,
                'idBeneficio': idBeneficio
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

// Função para retornar os ids das taxas na grid
function getTaxasId()
{
    // Verificando se a tabela foi inicializada
    if(!TableTaxasOfBeneficio) {
        return false;
    }

    // Variável local que armazenará os ids das taxas
    var taxas = [];

    // Carregando as taxas
    $.each(TableTaxasOfBeneficio.rows().data(),function (index, val) {
        taxas[index] = val[0];
    });

    // Retorno
    return  taxas;
}

//consulta via select2
$("#taxa_id_beneficios").select2({
    placeholder: 'Selecione uma Taxa',
    //minimumInputLength: 3,
    allowClear: true,
    width: 718,
    ajax: {
        type: 'POST',
        url: '/index.php/seracademico/util/beneficio/createQuery',//"{{ route('seracademico.util.select2')  }}",
        dataType: 'json',
        delay: 250,
        crossDomain: true,
        data: function (params) {
            return {
                'search':     params.term, // search term
                'tableName':  'fin_taxas',
                'displayfieldName':  'nome',
                'searchFieldsNames': ['nome', 'codigo'],
                'page':       params.page || 1,
                'taxas' :  getTaxasId()
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

