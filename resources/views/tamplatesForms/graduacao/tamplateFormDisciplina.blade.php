<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-8">
                <div class="form-group">
				{!! Form::label('nome', 'Nome *') !!}
				{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('codigo', 'Código *') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('carga_horaria', 'Carga Horária') !!}
				{!! Form::text('carga_horaria', Session::getOldInput('carga_horaria')  , array('class' => 'form-control numberFor')) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('qtd_credito', 'Qtd Crédito') !!}
				{!! Form::text('qtd_credito', Session::getOldInput('qtd_credito')  , array('class' => 'form-control numberFor')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('qtd_falta', 'Qtd. Faltas') !!}
				{!! Form::text('qtd_falta', Session::getOldInput('qtd_falta')  , array('class' => 'form-control numberThree')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('tipo_disciplina_id', 'Tipo Disciplina') !!}
				{!! Form::select('tipo_disciplina_id', $loadFields['tipodisciplina'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('tipo_avaliacao_id', 'Tipo Avaliação') !!}
				{!! Form::select('tipo_avaliacao_id', $loadFields['tipoavaliacao'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>


        <hr class="hr-line-dashed"/>
        <div class="row">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#cargahoraria" aria-controls="dados" data-toggle="tab"><i class="material-icons">event</i> Carga Horária</a>
                    </li>
                </ul>
                <!-- End Nav tabs -->

                <!-- Tab panes -->
                <div class="tab-content">

                    {{--Aba Carga Horária--}}
                    <div role="tabpanel" class="tab-pane active" id="datas">
                        <br/>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('carga_horaria_pratica', 'Carga Horária Prática') !!}
                                    {!! Form::text('carga_horaria_pratica', Session::getOldInput('carga_horaria_pratica')  , array('class' => 'form-control numberFor')) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('carga_horaria_teorica', 'Carga Horária Teórica') !!}
                                    {!! Form::text('carga_horaria_teorica', Session::getOldInput('carga_horaria_teorica')  , array('class' => 'form-control numberFor')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--FIM Carga Horária--}}

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
                        <a href="{{ route('seracademico.graduacao.disciplina.index') }}" class="btn btn-primary btn-block"> <i class="fa fa-long-arrow-left"></i>  Voltar</a>
                    </div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                    </div>
                </div>
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

            $('#formDisciplina').bootstrapValidator({
                fields: {
                    nome: {
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
                }
            });

        });
    </script>
@stop