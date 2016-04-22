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
                    {!! Form::label('codigo', 'Codigo *') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('curso_id', 'Curso') !!}
                    {!! Form::select('curso_id', $loadFields['curso'] , null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
				{!! Form::label('ano', 'Ano *') !!}
				{!! Form::text('ano', Session::getOldInput('ano')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    
				{!! Form::label('valido_inicio', 'Válidade (Início)') !!}
				{!! Form::text('valido_inicio', Session::getOldInput('valido_inicio'), array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    
				{!! Form::label('valido_fim', 'Validade (Fim)') !!}
				{!! Form::text('valido_fim', Session::getOldInput('valido_fim'), array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
        </div>

        <div class="row">

            <div class="form-group col-md-1">
                {!! Form::label('ativar', 'Ativar') !!}
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('ativo', 0) !!}
                    {!! Form::checkbox('ativo', 1, null, array('class' => 'form-control', 'id'=>'ativo')) !!}
                    {!! Form::label('ativo', 'Ativar', false) !!}
                </div>
            </div>
		</div>
        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-2">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
            <div class="col-md-2">
                <a href="{{ route('seracademico.posgraduacao.curriculo.index') }}" class="btn btn-primary btn-block">Voltar</a>
            </div>
        </div>
        {{--Fim Buttons Submit e Voltar--}}
	</div>
</div>

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '#ativo', function () {
                if($(this).is(':checked')) {
                    window.alert('ATENÇÃO: Marcando esse currículo como ativo, estará automaticamente desativando o atual ativo.');
                }
            });

            console.log(Lang.getLocale());
            Lang.setLocale('pt-BR');

            $('#formCurriculo').bootstrapValidator({
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