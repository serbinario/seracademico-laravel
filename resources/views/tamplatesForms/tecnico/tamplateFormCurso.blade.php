<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome *') !!}
                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('codigo', 'Código *') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo')  , array('class' => 'form-control')) !!}
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
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('carga_horaria', 'Carga horária total') !!}
                    {!! Form::text('carga_horaria', Session::getOldInput('carga_horaria')  , array('class' => 'form-control number')) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('tipo_curso_id', 'Tipo Curso *') !!}
                    {!! Form::select('tipo_curso_id', $loadFields['tipocurso'], null,  array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">                    
				{!! Form::label('cordenador_id', 'Cordenador') !!}
				{!! Form::select('cordenador_id', (['' =>  'Selecione um Cordenador'] + $loadFields['professor']->toArray()), null, array('class' => 'form-control')) !!}
                </div>
            </div>
            
            {{--<div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('tipo_nivel_sistema_id', 'Nível Sistema') !!}
                    {!! Form::select('tipo_nivel_sistema_id', $loadFields['tiponivelsistema'], null,  array('class' => 'form-control')) !!}
                </div>
            </div>--}}
		</div>

        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                <div class="btn-group">
                <a href="{{ route('seracademico.tecnico.curso.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
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
            console.log(Lang.getLocale());
            Lang.setLocale('pt-BR');

            $('#formCurso').bootstrapValidator({
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
                    duracao_meses: {
                        validators: {
                            numeric: {
                                message: Lang.get('validation.numeric', { attribute: 'Duraçao' })
                            }
                        }
                    },
                    numero_decreto_aut: {
                        validators: {
                            numeric: {
                                message: Lang.get('validation.numeric', { attribute: 'N' })
                            }
                        }
                    },
                    carga_horaria: {
                        validators: {
                            notEmpty: {
                                message: Lang.get('validation.required', { attribute: 'Carga Horária Total' })
                            }
                        }
                    }
                }
            });

        });
    </script>
@stop