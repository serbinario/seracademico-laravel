@extends('menu')


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="flaticon-teacher-at-the-blackboard"></i>
                    Cadastrar Professor</h4>
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

            {!! Form::open(['route'=>'seracademico.posgraduacao.professor.store', 'method' => "POST", 'id' => 'formProfessor', 'enctype' => 'multipart/form-data']) !!}
                @include('tamplatesForms.tamplateFormProfessor')
            {!! Form::close() !!}
        </div>
    </div>

    @section('javascript')
        <script type="text/javascript">
            //Carregando as cidades
            $(document).on('change', "#estado", function () {
                //Removendo as cidades
                $('#cidade option').remove();

                //Removendo as Bairros
                $('#bairro option').remove();

                //Recuperando o estado
                var estado = $(this).val();

                if (estado !== "") {
                    var dados = {
                        'table' : 'cidades',
                        'field_search' : 'estados_id',
                        'value_search': estado,
                    };

                    jQuery.ajax({
                        type: 'POST',
                        url: '{{ route('seracademico.util.search')  }}',
                        data: dados,
                        datatype: 'json',
                        headers: {
                            'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                        },
                    }).done(function (json) {
                        var option = "";

                        option += '<option value="">Selecione uma cidade</option>';
                        for (var i = 0; i < json.length; i++) {
                            option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                        }

                        $('#cidade option').remove();
                        $('#cidade').append(option);
                    });
                }
            });

            //Carregando os bairros
            $(document).on('change', "#cidade", function () {
                //Removendo as Bairros
                $('#bairro option').remove();

                //Recuperando a cidade
                var cidade = $(this).val();

                if (cidade !== "") {
                    var dados = {
                        'table' : 'bairros',
                        'field_search' : 'cidades_id',
                        'value_search': cidade,
                    };

                    jQuery.ajax({
                        type: 'POST',
                        url: '{{ route('seracademico.util.search')  }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{  csrf_token() }}'
                        },
                        data: dados,
                        datatype: 'json'
                    }).done(function (json) {
                        var option = "";

                        option += '<option value="">Selecione um bairro</option>';
                        for (var i = 0; i < json.length; i++) {
                            option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                        }

                        $('#bairro option').remove();
                        $('#bairro').append(option);
                    });
                }
            });

            //consulta via select2
            $("#instituicao-graduacao").select2({
                placeholder: 'Selecione uma instituição',
                minimumInputLength: 3,
                width: 400,
                ajax: {
                    type: 'POST',
                    url: "{{ route('seracademico.util.select2')  }}",
                    dataType: 'json',
                    delay: 250,
                    crossDomain: true,
                    data: function (params) {
                        return {
                            'search':     params.term, // search term
                            'tableName':  'fac_instituicoes',
                            'fieldName':  'nome',
                            'fieldWhere':  'nivel',
                            'valueWhere':  '3',
                            'page':       params.page || 1
                        };
                    },
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
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
                    }
                }
            });

            //consulta via select2
            $("#instituicao-pos").select2({
                placeholder: 'Selecione uma instituição',
                minimumInputLength: 3,
                width: 400,
                ajax: {
                    type: 'POST',
                    url: "{{ route('seracademico.util.select2')  }}",
                    dataType: 'json',
                    delay: 250,
                    crossDomain: true,
                    data: function (params) {
                        return {
                            'search':     params.term, // search term
                            'tableName':  'fac_instituicoes',
                            'fieldName':  'nome',
                            'fieldWhere':  'nivel',
                            'valueWhere':  '3',
                            'page':       params.page || 1
                        };
                    },
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
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
                    }
                }
            });

            //consulta via select2
            $("#instituicao-mestrado").select2({
                placeholder: 'Selecione uma instituição',
                minimumInputLength: 3,
                width: 400,
                ajax: {
                    type: 'POST',
                    url: "{{ route('seracademico.util.select2')  }}",
                    dataType: 'json',
                    delay: 250,
                    crossDomain: true,
                    data: function (params) {
                        return {
                            'search':     params.term, // search term
                            'tableName':  'fac_instituicoes',
                            'fieldName':  'nome',
                            'fieldWhere':  'nivel',
                            'valueWhere':  '3',
                            'page':       params.page || 1
                        };
                    },
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
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
                    }
                }
            });

            //consulta via select2
            $("#instituicao-doutorado").select2({
                placeholder: 'Selecione uma instituição',
                minimumInputLength: 3,
                width: 400,
                ajax: {
                    type: 'POST',
                    url: "{{ route('seracademico.util.select2')  }}",
                    dataType: 'json',
                    delay: 250,
                    crossDomain: true,
                    data: function (params) {
                        return {
                            'search':     params.term, // search term
                            'tableName':  'fac_instituicoes',
                            'fieldName':  'nome',
                            'fieldWhere':  'nivel',
                            'valueWhere':  '3',
                            'page':       params.page || 1
                        };
                    },
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
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
                    }
                }
            });
        </script>
    @stop
@stop
