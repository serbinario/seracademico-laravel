@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Cadastrar Acervo</h4>
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
            {!! Form::open(['route'=>'seracademico.biblioteca.storeAcervo', 'method' => "POST" ]) !!}
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
                }

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
                            $('#nome').val("")
                            $('#sobrenome').val("")
                            //location.href = "/serbinario/calendario/index/";
                        }
                    });
                } else {
                    swal("Os campos nome e sobrenome são obrigatórios", "Click no botão abaixo!", "warning");
                }
            });
        });

        function maiuscula(id) {
            //palavras para ser ignoradas
            var wordsToIgnore = ["DOS", "DAS", "de", "do", "dos", "Dos", "Das", "das"],
                    minLength = 2;
            var str = $('#' + id).val();
            var getWords = function (str) {
                return str.match(/\S+\s*/g);
            }
            $('#' + id).each(function () {
                var words = getWords(this.value);
                $.each(words, function (i, word) {
                    // somente continua se a palavra nao estiver na lista de ignorados
                    if (wordsToIgnore.indexOf($.trim(word)) == -1 && $.trim(word).length > minLength) {
                        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
                    } else {
                        words[i] = words[i].toLowerCase();
                    }
                });
                this.value = words.join("");
            });
        }
        ;

        //Deixar letra maiúscula
        $(document).ready(function ($) {
            // Chamada da funcao upperText(); ao carregar a pagina
            upperText();
            // Funcao que faz o texto ficar em uppercase
            function upperText() {

                // Para tratar o colar
                $("#sobrenome").bind('paste', function (e) {
                    var el = $(this);
                    setTimeout(function () {
                        var text = $(el).val();
                        el.val(text.toUpperCase());
                    }, 100);
                });

                // Para tratar quando é digitado
                $("#sobrenome").keypress(function () {
                    var el = $(this);
                    if (!el.hasClass('semCaixaAlta')) {
                        console.log('asdas');
                        setTimeout(function () {
                            var text = $(el).val();
                            el.val(text.toUpperCase());
                        }, 100);
                    }
                });
            }

        });
    </script>
@stop