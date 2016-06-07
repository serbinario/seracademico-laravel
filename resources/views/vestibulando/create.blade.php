@extends('menu')


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="fa fa-user"></i>
                Cadastrar Vestibulando
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

            {!! Form::open(['route'=>'seracademico.vestibulando.store', 'method' => "POST", 'id' => 'formVestibulando', 'enctype' => 'multipart/form-data']) !!}
                @include('tamplatesForms.graduacao.tamplateFormVestibulando')
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

            //consulta via select2 da instituição
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

            //consulta via select2 da formação acadêmica
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
                    },
                    cache: true
                }
            });

            // Validações
//            $('#formVestibulando').bootstrapValidator({
//                fields: {
//                    'nome': {
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
//                    'data_nasciemento': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Data Nascimento' })
//                            }
//                        }
//                    },
//                    'cpf': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'CPF' })
//                            }
//                        }
//                    },
//                    'nome_pai': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Nome Pai' })
//                            }
//                        }
//                    },
//                    'nome_mae': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Nome Mae' })
//                            }
//                        }
//                    },
//                    'identidade': {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Identidade' })
//                            }
//                        }
//                    }
//                },
//            });

            // Evento para pesquisar o cpf do digito no search
            $(document).on('click', '#btnSearchCpf', function () {
                // Recuperndo o valor da consulta
                var serachValue = $("#searchCpf").val();

                // Verificando se algum valor foi digitado
                if(!serachValue) {
                    swal("Você precisa digitar um cpf", "Click no botão ok para voltar a página", "error");
                    return false;
                }

                // Requisição ajax
                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.vestibulando.search')  }}',
                    data: {'cpf' : serachValue},
                    datatype: 'json'
                }).done(function (json) {
                    if(json.success) {
                        $("input:text[name='pessoa[nome]']").val(json.dados[0].nome);
                        $("input:text[name='pessoa[data_nasciemento]']").val(json.dados[0].data_nasciemento);
                        $("select[name='pessoa[sexos_id]'] option[value='"+ json.dados[0].sexos_id +"']").attr("selected", "selected");
                        $("select[name='pessoa[estados_civis_id]'] option[value='"+ json.dados[0].estados_civis_id +"']").attr("selected", "selected");
                        $("select[name='pessoa[cores_racas_id]'] option[value='"+ json.dados[0].cores_racas_id +"']").attr("selected", "selected");
                        $("select[name='pessoa[tipos_sanguinios_id]'] option[value='"+ json.dados[0].tipos_sanguinios_id +"']").attr("selected", "selected");
                        $("input:text[name='pessoa[nacionalidade]']").val(json.dados[0].nacionalidade);
                        $("select[name='pessoa[uf_nascimento_id]'] option[value='"+ json.dados[0].uf_nascimento_id +"']").attr("selected", "selected");
                        $("input:text[name='pessoa[naturalidade]']").val(json.dados[0].naturalidade);
                        $("input:text[name='pessoa[nome_pai]']").val(json.dados[0].nome_pai);
                        $("input:text[name='pessoa[nome_mae]']").val(json.dados[0].nome_mae);
                        $("input:text[name='pessoa[identidade]']").val(json.dados[0].identidade);
                        $("input:text[name='pessoa[orgao_rg]']").val(json.dados[0].orgao_rg);
                        $("input:text[name='pessoa[data_expedicao]']").val(json.dados[0].data_expedicao);
                        $("input:text[name='pessoa[cpf]']").val(json.dados[0].cpf);
                        $("input:text[name='pessoa[cpf]']").prop('readonly', true);
                        $("input:text[name='pessoa[titulo_eleitoral]']").val(json.dados[0].titulo_eleitoral);
                        $("input:text[name='pessoa[zona]']").val(json.dados[0].zona);
                        $("input:text[name='pessoa[secao]']").val(json.dados[0].secao);
                        $("input:text[name='pessoa[resevista]']").val(json.dados[0].resevista);
                        $("input:text[name='pessoa[catagoria_resevista]']").val(json.dados[0].catagoria_resevista);
                        $("input:checkbox[name='pessoa[deficiencia_fisica]']").attr('checked', json.dados[0].deficiencia_fisica);
                        $("input:checkbox[name='pessoa[deficiencia_auditiva]']").attr('checked', json.dados[0].deficiencia_auditiva);
                        $("input:checkbox[name='pessoa[deficiencia_visual]']").attr('checked', json.dados[0].deficiencia_visual);
                        $("input:checkbox[name='pessoa[deficiencia_outra]']").attr('checked', json.dados[0].deficiencia_outra);
                        $("input:text[name='pessoa[endereco][logradouro]']").val(json.dados[0].endereco.logradouro);
                        $("input:text[name='pessoa[endereco][cep]']").val(json.dados[0].endereco.cep);
                        $("input:text[name='pessoa[endereco][numero]']").val(json.dados[0].endereco.numero);

                        // Validando o estado
                        if(json.dados[0].endereco.bairro) {
                            $("select[name='estado'] option[value='"+ json.dados[0].endereco.bairro.cidade.estado.id +"']").attr("selected", "selected");
                            $("select[name='cidade']").append("<option value='"+ json.dados[0].endereco.bairro.cidade.id +"'>" + json.dados[0].endereco.bairro.cidade.nome + "</option>");
                            $("select[name='pessoa[endereco][bairros_id]']").append("<option value='"+ json.dados[0].endereco.bairro.id +"'>" + json.dados[0].endereco.bairro.nome + "</option>");
                        }

                        $("input:text[name='pessoa[endereco][complemento]']").val(json.dados[0].endereco.complemento);
                        $("input:text[name='pessoa[email]']").val(json.dados[0].email);
                        $("input:text[name='pessoa[telefone_fixo]']").val(json.dados[0].telefone_fixo);
                        $("input:text[name='pessoa[celular]']").val(json.dados[0].celular);
                        $("input:text[name='pessoa[celular2]']").val(json.dados[0].celular2);
                        $("input:text[name='pessoa[ano_conclusao_medio]']").val(json.dados[0].ano_conclusao_medio);
                        $("input:text[name='pessoa[outra_escola]']").val(json.dados[0].outra_escola);

                        // Validando a instituição escolar
                        if(json.dados[0].instituicao_escolar) {
                            $("#instituicao").append($('<option>', {value: json.dados[0].instituicao_escolar.id, text: json.dados[0].instituicao_escolar.nome}));
                            $("#instituicao option[name='" + json.dados[0].instituicao_escolar.id + "']").prop('selected',true);
                            $('#instituicao').trigger('change');
                        }
                    } else {
                        swal(json.msg, "Click no botão ok para voltar a página", "error");
                        return false;
                    }
                });

            });

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

            // Evento para selecionar os turnos da primeira opção de curso
            $(document).on('change', '#primeira_opcao_curso_id', function () {
                // Recuperando o id do curso
                var idCurso = $(this).find('option:selected').val();

                // verificando se o curso foi selecionado
                if(idCurso) {
                    // recuperando os options
                    getTurnosByCurso(idCurso, '#primeira_opcao_turno_id');
                }
            });

            // Evento para selecionar os turnos da segunda opção de curso
            $(document).on('change', '#segunda_opcao_curso_id', function () {
                // Recuperando o id do curso
                var idCurso = $(this).find('option:selected').val();

                // verificando se o curso foi selecionado
                if(idCurso) {
                    // recuperando os options
                    getTurnosByCurso(idCurso, '#segunda_opcao_turno_id');
                }
            });

            // Evento para selecionar os turnos da segunda opção de curso
            $(document).on('change', '#terceira_opcao_curso_id', function () {
                // Recuperando o id do curso
                var idCurso = $(this).find('option:selected').val();

                // verificando se o curso foi selecionado
                if(idCurso) {
                    // Gerando os options
                    getTurnosByCurso(idCurso, '#terceira_opcao_turno_id');
                }
            });

            /**
             *
             * @param idCurso
             */
            function getTurnosByCurso (idCurso, idHtml) {
                // Requisição ajax
                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.graduacao.curso.getTurnosByCurso')  }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    data: {'idCurso' : idCurso},
                    datatype: 'json'
                }).done(function (json) {
                    // Variável que armazenará o html
                    var options = '';

                    // Criando os options
                    options += '<option value="">Selecione um Turno</option>';
                    for (var i = 0; i < json.data.length; i++) {
                        options += '<option value="' + json.data[i]['id'] + '">' + json.data[i]['nome'] + '</option>';
                    }

                    // Gerando o html
                    $(idHtml).find('option').remove();
                    $(idHtml).append(options);
                });
            }
        </script>
    @stop
@stop
