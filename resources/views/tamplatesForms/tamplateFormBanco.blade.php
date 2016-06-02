<div class="row">
	<div class="col-md-10">
		<div class="row">
            <div class="col-md-9">
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
		</div>
	</div>
</div>

{{--Buttons Submit e Voltar--}}
<div class="row">
	<div class="col-md-9"></div>
	<div class="col-md-3">
		<div class="btn-group btn-group-justified">
			<div class="btn-group">
				<a href="{{ route('seracademico.banco.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
			<div class="btn-group">
				{!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
			</div>
		</div>
	</div>
</div>