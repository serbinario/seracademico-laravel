<div class="row">
	<div class="col-md-10">
		<div class="row">
            <div class="col-md-6">
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

			<div class="col-md-3">
				<div class="form-group">

					{!! Form::label('numero_banco', 'Nº Banco *') !!}
					{!! Form::text('numero_banco', Session::getOldInput('numero_banco')  , array('class' => 'form-control')) !!}
				</div>
			</div>
		</div>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#boletos" aria-controls="boletos" role="tab" data-toggle="tab">Boletas</a>
                    </li>
                </ul>
                <!-- End Nav tabs -->

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="boletos"><br>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#convenio" aria-controls="convenio" role="tab" data-toggle="tab">Convênio</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#info" aria-controls="info" role="tab" data-toggle="tab">Info. Básicas</a>
                                    </li>

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="convenio"><br><br><br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('numero_conta', 'Nº Conta *') !!}
                                                                {!! Form::text('numero_conta', Session::getOldInput('numero_conta')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('numero_agencia', 'Agência *') !!}
                                                                {!! Form::text('numero_agencia', Session::getOldInput('numero_agencia')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('numero_convenio', 'Convênio *') !!}
                                                                {!! Form::text('numero_convenio', Session::getOldInput('numero_convenio')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('carteira', 'Carteira *') !!}
                                                                {!! Form::text('carteira', Session::getOldInput('carteira')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('carteira_var', 'Carteira Var. *') !!}
                                                                {!! Form::text('carteira_var', Session::getOldInput('carteira_var')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('mascara_nn', 'Mascara N.N. *') !!}
                                                                {!! Form::text('mascara_nn', Session::getOldInput('mascara_nn')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="info"><br> <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('tipo_moeda_id', 'Moeda *') !!}
                                                                {!! Form::select('tipo_moeda_id', (['' => 'Selecione um banco'] + $loadFields['financeiro\\tipomoeda']->toArray()), Session::getOldInput('aceite')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('aceite', 'Aceite *') !!}
                                                                {!! Form::text('aceite', Session::getOldInput('aceite')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('especie', 'Espécie *') !!}
                                                                {!! Form::text('especie', Session::getOldInput('especie')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('local_pagamento', 'Local Pagamento *') !!}
                                                                {!! Form::text('local_pagamento', Session::getOldInput('local_pagamento')  , array('class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
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
				<a href="{{ route('seracademico.financeiro.banco.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
			<div class="btn-group">
				{!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
			</div>
		</div>
	</div>
</div>