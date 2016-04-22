<div class="row">
	<div class="col-md-12">
		<div class="row">

            <div class="col-md-8">
                <div class="form-group">
				{!! Form::label('nome', 'Nome completo') !!}
				{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('sobrenome', 'Sobrenome') !!}
				{!! Form::text('sobrenome', Session::getOldInput('sobrenome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>
	</div>
    <div class="col-md-12">
        {!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'id' => 'submitForm')) !!}
    </div>
</div>