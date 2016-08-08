<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome *') !!}
                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    @if(isset($model->id))
                        {!! Form::label('hora_inicial', 'Hora Inicial') !!}
                        {!! Form::text('hora_inicial', $model->hora_inicial ?? '00:00:00', array('class' => 'form-control', 'placeholder' => 'HH:mm:ss')) !!}
                    @else
                        {!! Form::label('hora_inicial', 'Hora Inicial') !!}
                        {!! Form::text('hora_inicial', '00:00:00', array('class' => 'form-control', 'placeholder' => 'HH:mm:ss')) !!}
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                @if(isset($model->id))
                    {!! Form::label('hora_final', 'Hora Final') !!}
                    {!! Form::text('hora_final', $model->hora_final ?? '00:00:00', array('class' => 'form-control', 'placeholder' => 'HH:mm:ss')) !!}
                @else
                    {!! Form::label('hora_final', 'Hora Final') !!}
                    {!! Form::text('hora_final', '00:00:00', array('class' => 'form-control', 'placeholder' => 'HH:mm:ss')) !!}
                @endif
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('turno_id', 'Turno') !!}
                    {!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control')) !!}
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
                <a href="{{ route('seracademico.hora.index') }}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i>  Voltar</a>
            </div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'id' => 'submitForm')) !!}
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script type="text/javascript">
        // validação
        $('#formHora').bootstrapValidator({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nome: {
                    validators: {
                        notEmpty: {
                            message: 'Campo Hora Inicial é obrigatório'
                        }
                    }
                },
                hora_inicial: {
                    validators: {
                        notEmpty: {
                            message: 'Campo Hora Inicial é obrigatório'
                        },
                        regexp: {
                            regexp: '^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$',
                            message: 'Formato da hora não é válido. HH:mm:ss'
                        }
                    }
                },
                hora_final: {
                    validators: {
                        notEmpty: {
                            message: 'Campo Hora Final é obrigatório'
                        },
                        regexp: {
                            regexp: '^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$',
                            message: 'Formato da hora não é válido. HH:mm:ss'
                        }
                    }
                }
            }
        });
    </script>
@endsection