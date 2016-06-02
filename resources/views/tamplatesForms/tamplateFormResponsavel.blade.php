<div class="row">
	<div class="col-md-12">
		<div class="row">

            <div class="col-md-8">
                <div class="form-group">
				{!! Form::label('nome', 'Nome') !!}
				{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control', 'onkeyup' => 'maiuscula("nome")', 'id' => 'nome')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
				{!! Form::label('sobrenome', 'Último Sobrenome') !!}
				{!! Form::text('sobrenome', Session::getOldInput('sobrenome')  , array('class' => 'form-control', 'id' => 'sobrenome')) !!}
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
                <a href="{{ route('seracademico.biblioteca.indexResponsavel') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
    {{--Fim Buttons Submit e Voltar--}}
</div>