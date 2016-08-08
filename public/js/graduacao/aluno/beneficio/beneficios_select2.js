// //consulta via select2
// $("#taxa_id_beneficios").select2({
//     placeholder: 'Selecione uma Taxa',
//     //minimumInputLength: 3,
//     width: 718,
//     ajax: {
//         type: 'POST',
//         url: '/index.php/seracademico/util/select2',//"{{ route('seracademico.util.select2')  }}",
//         dataType: 'json',
//         delay: 250,
//         crossDomain: true,
//         data: function (params) {
//             return {
//                 'search':     params.term, // search term
//                 'tableName':  'fin_taxas',
//                 'fieldName':  'nome',
//                 'page':       params.page || 1
//             };
//         },
//         processResults: function (data, params) {
//
//             // parse the results into the format expected by Select2
//             // since we are using custom formatting functions we do not need to
//             // alter the remote JSON data, except to indicate that infinite
//             // scrolling can be used
//             params.page = params.page || 1;
//
//             return {
//                 results: data.data,
//                 pagination: {
//                     more: data.more
//                 }
//             };
//         },
//         cache: true
//     }
// });
