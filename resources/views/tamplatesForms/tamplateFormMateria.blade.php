<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome *: max 60 caracteres (0-9 A-Z .-[ ]) ') !!}
                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('codigo', 'Codigo *: max 8 caracteres ') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo')  , array('class' => 'form-control codigo')) !!}
                </div>
            </div>
		</div>
        <div class="row">
                <div class="form-group col-md-12">
                    {!! Form::label('anotacao', 'Anotações: max 500 caracteres') !!}

                    {!! Form::textarea('anotacao', Session::getOldInput('anotacao') , array('class' => 'form-control', 'rows'=>'3')) !!}
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
                <a href="{{ route('seracademico.materia.index') }}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i>  Voltar</a>
            </div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'id' => 'submitForm')) !!}
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script type="text/javascript">

        $('#formMateria').bootstrapValidator({
            fields: {
                'nome': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Nome' })
                        }
                    }
                },
                'codigo': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'código' })
                        }
                    }
                }
            },
        });



    </script>
@stop