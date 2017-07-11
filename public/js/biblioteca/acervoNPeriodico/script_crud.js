/**
 * Created by Fabio Aguiar on 20/03/2017.
 */

$(document).ready(function () {
    $('#cursos').multiselect({
        buttonClass: 'btn-default',
        nonSelectedText: 'Selecione um Curso'
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

    //consulta via select2 segunda entrada 1
    $("#autor-1").select2({
        placeholder: 'Selecione um responsável',
        allowClear: true,
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        width: 400,
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

    //consulta via select2 segunda entrada 2
    $("#autor-2").select2({
        placeholder: 'Selecione um responsável',
        allowClear: true,
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        width: 400,
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

    //consulta via select2 segunda entrada 3
    $("#autor-3").select2({
        placeholder: 'Selecione um responsável',
        allowClear: true,
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        width: 400,
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


    //consulta via select2 segunda entrada 1
    $("#responsavel-1").select2({
        placeholder: 'Selecione um responsável',
        allowClear: true,
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        width: 400,
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

    //consulta via select2 segunda entrada 2
    $("#responsavel-2").select2({
        placeholder: 'Selecione um responsável',
        allowClear: true,
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        width: 400,
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

    //consulta via select2 segunda entrada 3
    $("#responsavel-3").select2({
        placeholder: 'Selecione um responsável',
        allowClear: true,
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        width: 400,
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

    //salvar responsável
    $("#save").click(function (event) {
        event.preventDefault();
        var dados = {
            'nome': $('#nome').val(),
            'sobrenome': $('#sobrenome').val(),
            'tipo_reponsavel_id': $('#tipo_reponsavel_id').val(),
        };

        if($('#nome').val() != "" && $('#tipo_reponsavel_id').val() != "") {
            $.ajax({
                url: "/index.php/seracademico/biblioteca/storeAjaxResponsavel",
                data: {
                    dados: dados,
                },
                dataType: "json",
                type: "POST",
                success: function (data) {
                    swal(data['msg'], "Click no botão abaixo!", "success");
                    $('#nome').val("");
                    $('#sobrenome').val("");
                    //location.href = "/serbinario/calendario/index/";
                }
            });
        } else {
            swal("Os campos nome e tipo responsável são obrigatórios", "Click no botão abaixo!", "warning");
        }
    });

    //Gerar o cutter ao selecionar um autor
    $("#auto-cutter").click(function (event) {
        //event.preventDefault();

        var autor  = $('select[id=autor-1] option:selected').val();
        var outro  = $('select[id=responsavel-1] option:selected').val();
        var titulo = $('input[name=titulo]').val();
        var nome = "";

        if(autor && !outro) {
            nome = autor;
        } else if (!autor && outro) {
            nome = outro;
        } else if (autor && outro) {
            nome = autor;
        }

        if(titulo) {

            var dados = {
                'autor' : nome,
                'titulo' : titulo
            };

            $.ajax({
                url: "/index.php/seracademico/biblioteca/getCutter",
                data: {
                    dados: dados
                },
                dataType: "json",
                type: "POST",
                success: function (data) {
                    if(data['result']) {
                        $('#cutter').val(data['result']);
                    }
                }
            });
        } else {
            swal("Você deve informar ao menos o título", "Click no botão abaixo!", "warning");
        }
    });

});
