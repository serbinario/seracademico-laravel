<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('curso_id', 'Curso *') !!}
                @if(isset($model->curriculo->curso->id))
                    @if(count($model->disciplinas) > 0)
                        {!! Form::select('curso_id',[$model->curriculo->curso->id => $model->curriculo->curso->nome], $model->curriculo->curso->id, array('id' => 'curso', 'class' => 'form-control', 'readonly' => 'readonly')) !!}
                    @else
                        {!! Form::select('curso_id', $loadFields['posgraduacao\\curso'], $model->curriculo->curso->id, array('id' => 'curso', 'class' => 'form-control')) !!}
                    @endif
                @else
                    {!! Form::select('curso_id', (['' => 'Selecione um curso'] + $loadFields['posgraduacao\\curso']->toArray()), null, array('id' => 'curso', 'class' => 'form-control')) !!}
                @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('curriculo_id', 'Currículo *') !!}
                    @if(isset($model->curriculo->id))
                        @if(count($model->disciplinas) > 0)
                            {!! Form::select('curriculo_id',[$model->curriculo->id => $model->curriculo->nome], $model->curriculo->id, array('id' => 'curriculo', 'class' => 'form-control', 'readonly' => 'readonly')) !!}
                        @else
                            {!! Form::select('curriculo_id', [$model->curriculo->id => $model->curriculo->nome], $model->curriculo->id, array('id' => 'curriculo', 'class' => 'form-control')) !!}
                        @endif
                    @else
                        {!! Form::select('curriculo_id', [], null, array('id' => 'curriculo', 'class' => 'form-control')) !!}
                    @endif
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('codigo', 'Código *') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo'), array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
				{!! Form::label('turno_id', 'Turno *') !!}
                    @if(isset($model->turno->id))
                        {!! Form::select('turno_id', [$model->turno->id => $model->turno->nome], $model->turno->id, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                        {{--{!! Form::select('semestre_id', $loadFields['posgraduacao\\semestre'], $model->semestre->id, array('class' => 'form-control', 'disabled' => 'disabled')) !!}--}}
                    @else
                        {!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            {{--<div class="col-md-6">--}}
                {{--<div class="form-group">--}}
                    {{--{!! Form::label('descricao', 'Descrição ') !!}--}}
                    {{--{!! Form::text('descricao', Session::getOldInput('codigo'), array('id' => 'descricao', 'class' => 'form-control')) !!}--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="col-md-2">
                {!! Form::label('sede_id', 'Sede *') !!}

                {!! Form::select('sede_id', $loadFields['sede'], null, array('class' => 'form-control')) !!}
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('duracao_meses', 'Duração (meses) ') !!}
                    {!! Form::text('duracao_meses', Session::getOldInput('duracao_meses')  , array('class' => 'form-control number')) !!}
                </div>
            </div>
        </div>
        <hr class="hr-line-dashed"/>
        <div class="row">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#datas" aria-controls="dados" data-toggle="tab">Datas</a>
                    </li>
                    {{--<li role="presentation">--}}
                        {{--<a href="#valores" aria-controls="contato" role="tab" data-toggle="tab"><i class="fa fa-money"></i> Valores </a>--}}
                    {{--</li>--}}
                    {{--<li role="presentation">--}}
                        {{--<a href="#vagas" aria-controls="ensMedio" role="tab" data-toggle="tab"><i class="material-icons">event_seat</i> Vagas</a>--}}
                    {{--</li>--}}
                    {{--<li role="presentation">--}}
                        {{--<a href="#sala" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">label</i> Sala de Aula</a>--}}
                    {{--</li>--}}
                </ul>
                <!-- End Nav tabs -->

                <!-- Tab panes -->
                <div class="tab-content">

                    {{--Aba Datas--}}
                    <div role="tabpanel" class="tab-pane active" id="datas">
                        <br/>
                        <div class="row">
                            {{--<div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('matricula_inicio', 'Matrícula (Início)') !!}
                                    {!! Form::text('matricula_inicio', Session::getOldInput('matricula_inicio'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('matricula_fim', 'Matrícula (Fim)') !!}
                                    {!! Form::text('matricula_fim', Session::getOldInput('matricila_fim'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>--}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('aula_inicio', 'Aula (Início)') !!}
                                    {!! Form::text('aula_inicio', Session::getOldInput('aula_inicio'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('aula_final', 'Aula (Final)') !!}
                                    {!! Form::text('aula_final', Session::getOldInput('aula_final'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--FIM Datas--}}

                </div>
                <!-- FIM Tab panes -->
            </div>
        </div>
        {{--FIM Linha da da Abas--}}


        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                <div class="btn-group">
                <a href="{{ route('seracademico.posgraduacao.turma.index') }}" class="btn btn-primary btn-block pull-right"><i class="fa fa-long-arrow-left"></i>   Voltar</a></div>
                <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right', 'id' => 'submitForm')) !!}
                </div>
            </div>


        </div>
        {{--Fim Buttons Submit e Voltar--}}
	</div>
</div>
</div>

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            Lang.setLocale('pt-BR');

            // Evento para preenchimento automático da descrição
            $(document).on('change', '#curso', function () {
                // Recuperando o texto do option selecionado e preenchendo a descrição
                $('#descricao').val($(this).find('option:selected').text());

                // Recuperando o id do curso selecionado
                var cursoId = $('#curso').val();

                // Requisição ajax
                jQuery.ajax({
                    type: 'GET',
                    url: '/index.php/seracademico/posgraduacao/curriculo/getByCurso/' + cursoId,
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    datatype: 'json'
                }).done(function (json) {
                    var option = '<option value="">Selecione um Currículo</option>';

                    for (var i = 0; i < json.dados.length; i++) {
                        option += '<option value="' + json.dados[i].id + '">' + json.dados[i].nome + '</option>';
                    }

                    $('#curriculo option').remove();
                    $('#curriculo').append(option);
                });
            });

            $('#formTurma').bootstrapValidator({
                fields: {
//                    descricao: {
//                        validators: {
//                            notEmpty: {
//                                message: Lang.get('validation.required', { attribute: 'Descrição' })
//                            }
//                        }
//                    },
                    codigo: {
                        validators: {
                            notEmpty: {
                                message: Lang.get('validation.required', { attribute: 'Código' })
                            }
                        }
                    }

                }
            });

        });
    </script>
@endsection
