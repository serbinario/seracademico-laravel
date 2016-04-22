<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-6">
                <div class="form-group">
				{!! Form::label('curso_id', 'Curso *') !!}
                @if(isset($model->curriculo->curso->id))
				    {!! Form::select('curso_id', $loadFields['curso'], $model->curriculo->curso->id, array('class' => 'form-control')) !!}
                @else
                    {!! Form::select('curso_id', $loadFields['curso'], null, array('class' => 'form-control')) !!}
                @endif
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('codigo', 'Código *') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo')  , array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    
				{!! Form::label('turno_id', 'Turno *') !!}
				{!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        {{--Linha da da Habas--}}
        <div class="row">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#datas" aria-controls="dados" data-toggle="tab"><i class="fa fa-male"></i> Datas</a>
                    </li>
                    <li role="presentation">
                        <a href="#valores" aria-controls="contato" role="tab" data-toggle="tab"><i class="fa fa-globe"></i> Valores </a>
                    </li>
                    <li role="presentation">
                        <a href="#vagas" aria-controls="ensMedio" role="tab" data-toggle="tab"><i class="fa fa-file-text"></i> Vagas</a>
                    </li>
                    <li role="presentation">
                        <a href="#sala" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="fa fa-file-text"></i> Sala de Aula</a>
                    </li>
                </ul>
                <!-- End Nav tabs -->

                <!-- Tab panes -->
                <div class="tab-content">

                    {{--Aba Datas--}}
                    <div role="tabpanel" class="tab-pane active" id="datas">
                        <br/>
                        <div class="row">
                            <div class="col-md-2">
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
                            </div>
                        </div>
                        <div class="row">
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

                    {{--Aba Valores--}}
                    <div role="tabpanel" class="tab-pane" id="valores">
                        <br/>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('valor', 'Valor') !!}
                                    {!! Form::text('valor', Session::getOldInput('valor')  , array('class' => 'form-control money')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('parcelas', 'Qtd. Parcelas') !!}
                                    {!! Form::text('parcelas', Session::getOldInput('parcelas')  , array('class' => 'form-control number')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('vencimento_inicial', 'Vencimento Inicial') !!}
                                    {!! Form::text('vencimento_inicial', Session::getOldInput('vencimento_inicial'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--FIM Aba Valores--}}

                    {{--Aba Vagas--}}
                    <div role="tabpanel" class="tab-pane" id="vagas">
                        <br/>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('maximo_vagas', 'Máximo Vagas') !!}
                                    {!! Form::text('maximo_vagas', Session::getOldInput('maximo_vagas')  , array('class' => 'form-control number')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('minimo_vagas', 'Mínimo Vagas') !!}
                                    {!! Form::text('minimo_vagas', Session::getOldInput('minimo_vagas')  , array('class' => 'form-control number')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('obs_vagas', 'Observação Vagas') !!}
                                    {!! Form::textarea('obs_vagas', Session::getOldInput('obs_vagas')  ,['size' => '50x5'] , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    {{--FIM Aba Vagas --}}

                    {{--Aba Salas--}}
                    <div role="tabpanel" class="tab-pane" id="sala">
                        <br/>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('sala_id', 'Sala') !!}
                                    {!! Form::select('sala_id', $loadFields['sala'], null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('obs_sala', 'Observação Sala') !!}
                                    {!! Form::textarea('obs_sala', Session::getOldInput('obs_sala') , ['size' => '50x5'] , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>



                    </div>
                    {{--FIM Aba Vagas --}}

                    {{--Aba Salas--}}
                    <div role="tabpanel" class="tab-pane" id="sala">
                        <br/>


                    </div>
                    {{--FIM Aba Salas --}}
                </div>
                <!-- FIM Tab panes -->
            </div>
        </div>
        {{--FIM Linha da da Abas--}}


        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-2">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right', 'id' => 'submitForm')) !!}
            </div>
            <div class="col-md-2">
                <a href="{{ route('seracademico.posgraduacao.turma.index') }}" class="btn btn-primary btn-block pull-right">Voltar</a>
            </div>
        </div>
        {{--Fim Buttons Submit e Voltar--}}
	</div>
</div>

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {

            console.log(Lang.getLocale());
            Lang.setLocale('pt-BR');

            $('#regexpForm').bootstrapValidator({
                fields: {
                    hora_inicial: {
                        validators: {
                            notEmpty: {
                                message: Lang.get('validation.required', { attribute: 'Nome' })
                            },
                            stringLength: {
                                max: 200,
                                message: Lang.get('validation.max', { attribute: 'Nome' })
                            }
                        }
                    },
                    codigo: {
                        validators: {
                            notEmpty: {
                                message: Lang.get('validation.required', { attribute: 'Código' })
                            }
                        }
                    },
                    ano: {
                        validators: {
                            numeric: {
                                message: Lang.get('validation.numeric', { attribute: 'Ano' })
                            }
                        }
                    }
                }
            });

        });
    </script>
@stop