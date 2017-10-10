<div class="row">
	<div class="col-md-10">
		<div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome *') !!}
                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>

			<div class="col-md-2">
				<div class="form-group">
					{!! Form::label('codigo', 'Código *') !!}
					{!! Form::text('codigo', Session::getOldInput('codigo')  , array('class' => 'form-control')) !!}
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('banco_id', 'Banco *') !!}
                    {!! Form::select('banco_id', (['' => 'Selecione um banco'] + $loadFields['financeiro\\banco']->toArray()),
                        null, array('class' => 'form-control')) !!}
				</div>
			</div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('conta', 'Conta *') !!}
                    {!! Form::text('conta', Session::getOldInput('conta')  , array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('agencia', 'Agência *') !!}
                    {!! Form::text('agencia', Session::getOldInput('agencia')  , array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group col-md-1" style="margin-top: 2%">
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('ativo', 0) !!}
                    {!! Form::checkbox('ativo', 1, null, array('class' => 'form-control')) !!}
                    {!! Form::label('ativo', 'Ativar', false) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <a href="{{ route('seracademico.financeiro.contaBancaria.index') }}"
                       class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a>
                </div>
                <div class="btn-group">
                    {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                </div>
            </div>
        </div>
    </div>
</div>