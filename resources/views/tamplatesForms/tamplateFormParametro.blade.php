<div class="row">
	<div class="col-md-10">
		<div class="row">

            <div class="col-md-8">
                <div class="form-group">
                    
				{!! Form::label('nome', 'Nome *') !!}
				{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
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
				<a href="{{ route('seracademico.parametro.index') }}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i>  Voltar</a>
			</div>
			<div class="btn-group">
				{!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'id' => 'submitForm')) !!}
			</div>
		</div>
	</div>
</div>