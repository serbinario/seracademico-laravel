<div class="row">
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Principais
                    dados</a></li>
            <li role="presentation"><a href="#curso" aria-controls="curso" role="tab" data-toggle="tab">Cursos</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="dados">
                <br/>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Título') !!}
                            {!! Form::text('titulo', Session::getOldInput('titulo') , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('subtitulo', 'Subtítulo') !!}
                            {!! Form::text('subtitulo', Session::getOldInput('subtitulo') ,  array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('cdd', 'CDD') !!}
                            {!! Form::text('cdd', Session::getOldInput('cdd')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('outro_cdd', 'Outra opção de CDD') !!}
                            {!! Form::text('outro_cdd', Session::getOldInput('outro_cdd')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('tipos_acervos_id', 'Tipo do acervo') !!}
                            {!! Form::select('tipos_acervos_id', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tipoacervo']->toArray()), Session::getOldInput('tipos_acervos_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('situacao_id', 'Situação') !!}
                            {!! Form::select('situacao_id', $loadFields['biblioteca\situacao'], Session::getOldInput('situacao_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('periodicidade', 'Periodicidade') !!}
                            {!! Form::text('periodicidade', Session::getOldInput('periodicidade'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('data_vencimento', 'Data de vencimento assinatura') !!}
                            {!! Form::text('data_vencimento', Session::getOldInput('data_vencimento'), array('class' => 'form-control datepicker date data2')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('exemplar_ref', 1) !!}
                            {!! Form::hidden('tipo_periodico', 2) !!}
                            {{--{!! Form::checkbox('exemplar_ref', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('exemplar_ref', 'Exemplar de referẽncia (Apenas consulta)', false) !!}--}}
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="curso">
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('curso-graduacao', 'Graduação/Tecnólogo') !!}
                            @if(isset($model->id))
                                <select class="form-control cursos" multiple="multiple" name="cursos[]" id="curso-graduacao">
                                    @foreach($cursos['graduacao'] as $value)
                                        <option value="{{ $value->id }}"
                                                @foreach($model->cursos->lists('id') as $c) @if($value->id == $c) selected="selected" @endif @endforeach>{{$value->nome}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control cursos" name="cursos[]" multiple id="curso-graduacao">
                                    @foreach($cursos['graduacao'] as $value)
                                        <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('curso-posgraduacao', 'Pós-Graduação/Curso Extensão') !!}
                            @if(isset($model->id))
                                <select class="form-control cursos" multiple="multiple" name="cursos[]" id="curso-posgraduacao">
                                    @foreach($cursos['pos'] as $value)
                                        <option value="{{ $value->id }}"
                                                @foreach($model->cursos->lists('id') as $c) @if($value->id == $c) selected="selected" @endif @endforeach>{{$value->nome}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control cursos" name="cursos[]" multiple id="curso-posgraduacao">
                                    @foreach($cursos['pos'] as $value)
                                        <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('curso-mestrado', 'Mestrado') !!}
                            @if(isset($model->id))
                                <select class="form-control cursos" multiple="multiple" name="cursos[]" id="curso-mestrado">
                                    @foreach($cursos['mestrado'] as $value)
                                        <option value="{{ $value->id }}"
                                                @foreach($model->cursos->lists('id') as $c) @if($value->id == $c) selected="selected" @endif @endforeach>{{$value->nome}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control cursos" name="cursos[]" multiple id="curso-mestrado">
                                    @foreach($cursos['mestrado'] as $value)
                                        <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Buttons Submit e Voltar--}}
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <a href="{{ route('seracademico.biblioteca.indexAcervoP') }}" class="btn btn-primary btn-block"><i
                                class="fa fa-long-arrow-left"></i> Voltar</a></div>
                <div class="btn-group">
                    {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
    <script type="text/javascript">

        $(document).ready(function () {

            $('.cursos').multiselect({
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
        });
    </script>
@stop