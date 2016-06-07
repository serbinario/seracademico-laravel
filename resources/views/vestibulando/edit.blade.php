@extends('menu')


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="fa fa-user"></i>
                Editar Vestibulando
            </h4>
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

            {!! Form::model($aluno, ['route'=> ['seracademico.vestibulando.update', $aluno->id], 'id' => 'formVestibulando', 'enctype' => 'multipart/form-data']) !!}
                @include('tamplatesForms.graduacao.tamplateFormVestibulando')
                {{--<a href="{{ route('seracademico.report.contratoAluno', ['id' => $aluno->id]) }}" target="_blank" class="btn btn-info">Contrato</a>--}}
            {!! Form::close() !!}
        </div>
    </div>
@stop
    @section('javascript')
        {{--<script src="{{ asset('/js/validacoes/validation_form_aluno.js')}}"></script>--}}

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
            $("#instituicao").select2({
                placeholder: 'Selecione uma instituição',
                minimumInputLength: 3,
                width: 750,
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
                            'valueWhere':  '2',
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
            $("#formacao").select2({
                placeholder: 'Selecione uma formação acadêmica',
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
                            'tableName':  'fac_cursos_superiores',
                            'fieldName':  'nome',
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

//            $('#formVestibulando').bootstrapValidator({
//                fields: {
//                    'pessoa[nome]': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Nome' })
//                            },
//                            stringLength: {
//                                max: 50,
//                                message: Lang.get('validation.max', { attribute: 'Nome' })
//                            }
//                        }
//                    },
//                    'pessoa[data_nasciemento]': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Data Nascimento' })
//                            }
//                        }
//                    },
//                    'pessoa[cpf]': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'CPF' })
//                            }
//                        }
//                    },
//                    'pessoa[nome_pai]': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Nome Pai' })
//                            }
//                        }
//                    },
//                    'pessoa[nome_mae]': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Nome Mae' })
//                            }
//                        }
//                    },
//                    'pessoa[identidade]': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Identidade' })
//                            }
//                        }
//                    },
//                    'vestibular_id': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Vestibular' })
//                            }
//                        }
//                    },
//                    'data_insricao_vestibular': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Data da inscrição' })
//                            }
//                        }
//                    },
//                    'primeira_opcao_curso_id': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Primeira opção de curso' })
//                            }
//                        }
//                    },
//                    'primeira_opcao_turno_id': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Primeira opção de turno' })
//                            }
//                        }
//                    }
//
//                },
//            });

            // Regra para carregamento dos cursos a partir do vestibular escolhido
            $(document).on('change', '#vestibular_id', function () {
                // Recuperando o id do vestibular selecionado
                var vestibularId = $(this).find("option:selected").val();

                // Verificando o id do vestibular
                if(vestibularId) {
                    jQuery.ajax({
                        type: 'POST',
                        url: '{{ route('seracademico.graduacao.curso.getByVestibular')  }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{  csrf_token() }}'
                        },
                        data: {'vestibularId' : vestibularId},
                        datatype: 'json'
                    }).done(function (json) {
                        var option = "";

                        option += '<option value="">Selecione um Curso</option>';
                        for (var i = 0; i < json.data.length; i++) {
                            option += '<option value="' + json.data[i]['id'] + '">' + json.data[i]['nome'] + '</option>';
                        }

                        $('#primeira_opcao_curso_id option').remove();
                        $('#primeira_opcao_curso_id').append(option);

                        $('#segunda_opcao_curso_id option').remove();
                        $('#segunda_opcao_curso_id').append(option);

                        $('#terceira_opcao_curso_id option').remove();
                        $('#terceira_opcao_curso_id').append(option);
                    });
                }
            });
        </script>

@stop
