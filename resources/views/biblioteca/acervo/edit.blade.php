@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Editar Acervo</h4>
            </div>
            <div class="col-sm-6 col-md-3">

            </div>
        </div>

        <div class="ibox-content">

            @if(Session::has('message'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <em> {!! session('message') !!}</em>
                </div>
            @endif

            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {!! Form::model($model, ['route'=> ['seracademico.biblioteca.updateAcervo', $model->id], 'method' => "POST" ]) !!}
                @include('tamplatesForms.tamplateFormArcevo')
            {!! Form::close() !!}
        </div>

    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#cursos').multiselect({
                buttonClass: 'btn-default',
                nonSelectedText: 'Selecione um Curso'
            });

            function formatRepo(repo) {
                if (repo.loading) return repo.text;

                var markup = '<option value="' + repo.id + '">' + repo.name + '</option>';
                return markup;
            }

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
                    url: "{{ route('seracademico.util.select2personalizado')  }}",
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
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
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
                    url: "{{ route('seracademico.util.select2personalizado')  }}",
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
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
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
                    url: "{{ route('seracademico.util.select2personalizado')  }}",
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
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
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
                    url: "{{ route('seracademico.util.select2personalizado')  }}",
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
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
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
                    url: "{{ route('seracademico.util.select2personalizado')  }}",
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
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
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
                    url: "{{ route('seracademico.util.select2personalizado')  }}",
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
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
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
                };

                if($('#nome').val() != "" && $('#sobrenome').val() != "") {
                    $.ajax({
                        url: "{{ route('seracademico.biblioteca.storeAjaxResponsavel')  }}",
                        data: {
                            dados: dados,
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{  csrf_token() }}'
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
                    swal("Os campos nome e sobrenome são obrigatórios", "Click no botão abaixo!", "warning");
                }
            });
        });

    </script>
@stop