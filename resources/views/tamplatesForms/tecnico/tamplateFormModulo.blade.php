<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('codigo', 'Codigo *') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
				    {!! Form::label('nome', 'Nome *') !!}
				    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-3 col-md-offset-9">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="{{ route('seracademico.tecnico.modulo.index') }}" class="btn btn-primary btn-block pull-right"> <i class="fa fa-long-arrow-left"></i>  Voltar</a>
                    </div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right')) !!}
                    </div>
                </div>
            </div>
        </div>
        {{--Fim Buttons Submit e Voltar--}}
	</div>
</div>

@section('javascript')
    <script type="text/javascript">
    </script>
@stop