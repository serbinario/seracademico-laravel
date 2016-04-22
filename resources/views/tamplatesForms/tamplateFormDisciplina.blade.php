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
				{!! Form::text('carga_horaria', Session::getOldInput('carga_horaria')  , array('class' => 'form-control number')) !!}
                </div>
            </div>
            {{--<div class="col-md-4">
                <div class="form-group">
				{!! Form::label('qtd_credito', 'qtd_credito') !!}
				{!! Form::text('qtd_credito', Session::getOldInput('qtd_credito')  , array('class' => 'form-control')) !!}
                </div>
            </div>--}}
            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('qtd_falta', 'Qtd. Faltas') !!}
				{!! Form::text('qtd_falta', Session::getOldInput('qtd_falta')  , array('class' => 'form-control number')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('tipo_disciplina_id', 'Tipo Disciplina') !!}
				{!! Form::select('tipo_disciplina_id', $loadFields['tipodisciplina'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            {{--<div class="col-md-4">
                <div class="form-group">
				{!! Form::label('tipo_avaliacao_id', 'Tipo Avaliação') !!}
				{!! Form::select('tipo_avaliacao_id', $loadFields['tipoavaliacao'], null, array('class' => 'form-control')) !!}
                </div>
            </div>--}}
		</div>

        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-2">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
            <div class="col-md-2">
                <a href="{{ route('seracademico.posgraduacao.disciplina.index') }}" class="btn btn-primary btn-block">Voltar</a>
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
                    carga_horaria: {
                        validators: {
                            stringLength: {
                                max: 4,
                                message: Lang.get('validation.max', { attribute: 'Carga Horária' })
                            }
                        }
                    },
                    qtd_falta: {
                        validators: {
                            stringLength: {
                                max: 4,
                                message: Lang.get('validation.max', { attribute: 'Quantidade de Faltas' })
                            }
                        }
                    }
                }
            });

        });
    </script>
@stop