<div class="row">
	<div class="col-md-10">
		<div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nome', 'nome') !!}
				{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('disciplina_id', 'disciplina_id') !!}
				{!! Form::select('disciplina_id', array(), NULL, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('situacao_nota_id', 'situacao_nota_id') !!}
				{!! Form::select('situacao_nota_id', array(), NULL, array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>
	</div>
</div>