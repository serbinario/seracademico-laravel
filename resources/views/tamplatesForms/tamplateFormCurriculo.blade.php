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
                    @if(isset($model) && count($model->disciplinas) > 0)
                        {!! Form::select('curso_id', $loadFields['curso'] , null, array('class' => 'form-control', 'disabled'=>'disabled')) !!}
                    @else
                        {!! Form::select('curso_id', $loadFields['curso'] , null, array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
				{!! Form::label('ano', 'Ano *') !!}
				{!! Form::text('ano', Session::getOldInput('ano')  , array('class' => 'form-control numberFor')) !!}
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
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                <div class="btn-group">
                <a href="{{ route('seracademico.posgraduacao.curriculo.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                </div>
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
                    swal("Marcando esse currículo como ativo, estará automaticamente desativando o atual ativo.", "Click no botão abaixo!", "warning");
                }
            });

            // Setando o texto do nome pelo curso escolhido
            $(document).on('change', "#curso_id", function () {
                var textCurso = $(this).find("option:selected").text();
                $("#nome").val(textCurso);
            });

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