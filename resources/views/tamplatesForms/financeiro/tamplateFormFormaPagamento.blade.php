<div class="row">
	<div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome *') !!}
                    {!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control', 'placeholder' => 'Nome da forma de pagamento')) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('codigo', 'Codigo *') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo') , array('class' => 'form-control', 'placeholder' => 'Código da forma de pagamento')) !!}
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="{{ route('seracademico.financeiro.formaPagamento.index') }}"
                           class="btn btn-primary btn-block">
                            <i class="fa fa-long-arrow-left"></i>  Voltar
                        </a>
                    </div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>