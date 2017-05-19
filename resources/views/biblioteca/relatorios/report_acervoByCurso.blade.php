@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">card_travel</i> Relatórios de livros por cursos</h4>
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

            {!! Form::open(['route'=>'seracademico.biblioteca.storeDiasLetivosBiblioteca', 'method' => "POST" ]) !!}

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('curso', 'Curso') !!}
                                {!! Form::select('curso', (["" => "Selecione o curso"] + $loadFields['posgraduacao\curso']->toArray()), Session::getOldInput('curso'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('area', 'Área de conhecimento') !!}
                                {!! Form::select('area', (["" => "Selecione a área"] + $loadFields['biblioteca\genero']->toArray()), Session::getOldInput('genero_id'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('assunto', 'Assunto') !!}
                                {!! Form::text('assunto', Session::getOldInput('assunto') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('responsavel', 'Responsável') !!}
                                {!! Form::select('responsavel', array(), Session::getOldInput('responsavel'), array('class' => 'form-control', 'id' => 'responsavel')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('outro_responsavel', 'Outro responsável') !!}
                                {!! Form::select('outro_responsavel', array(), Session::getOldInput('outro_responsavel'), array('class' => 'form-control', 'id' => 'outro_responsavel')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('titulo', 'Título') !!}
                                {!! Form::text('titulo', Session::getOldInput('titulo') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('cdd', 'CDD') !!}
                                {!! Form::text('cdd', Session::getOldInput('cdd') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('cutter', 'CUTTER') !!}
                                {!! Form::text('cutter', Session::getOldInput('cutter') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="cutter_ch" value="" class="form-control">
                                {!! Form::label('cutter_ch', "Cutter", false) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="area_ch" value="" class="form-control">
                                {!! Form::label('area_ch', "Área", false) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="titulo_ch" value="" class="form-control">
                                {!! Form::label('titulo_ch', "Título", false) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="autor_ch" value="" class="form-control">
                                {!! Form::label('autor_ch', "Autor", false) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="outro_ch" value="" class="form-control">
                                {!! Form::label('outro_ch', "Outro", false) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="ano_ch" value="" class="form-control">
                                {!! Form::label('ano_ch', "Ano", false) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="cdd_ch" value="" class="form-control">
                                {!! Form::label('cdd_ch', "CDD", false) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="cutter_ch" value="" class="form-control">
                                {!! Form::label('cutter_ch', "CUTTER", false) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="assunto_ch" value="" class="form-control">
                                {!! Form::label('assunto_ch', "Assunto", false) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br />
            {{--Buttons Submit e Voltar--}}
            <div class="row">
                <div class="col-md-3">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            {!! Form::submit('Gerar relatório', array('class' => 'btn btn-primary btn-block')) !!}
                        </div>
                    </div>
                </div>
                {{--Fim Buttons Submit e Voltar--}}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
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
    </script>
@stop
