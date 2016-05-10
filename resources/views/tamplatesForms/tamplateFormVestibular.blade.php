<div class="row">
	<div class="col-md-10">
		<div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('codigo', 'Codigo') !!}
				{!! Form::text('codigo', Session::getOldInput('codigo'), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nome', 'Nome') !!}
				{!! Form::text('nome', Session::getOldInput('nome'), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('data_inicial', 'Data Inicial') !!}
				{!! Form::text('data_inicial', null , array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('data_final', 'Data Final') !!}
				{!! Form::text('data_final', null, array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('hora_inicial', 'Hora Inicial') !!}
				{!! Form::text('hora_inicial', null , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('hora_final', 'Hora Final') !!}
				{!! Form::text('hora_final',null , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('qtd_vagas', 'Qtd. Vagas') !!}
				{!! Form::text('qtd_vagas', Session::getOldInput('qtd_vagas')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('instrucoes_boleto', 'Instruções de boleto') !!}
				{!! Form::text('instrucoes_boleto', Session::getOldInput('instrucoes_boleto')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('confirmacao_inscricao', 'Confirmação de Inscrição') !!}
				{!! Form::text('confirmacao_inscricao', Session::getOldInput('confirmacao_inscricao')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('banco_id', 'Banco *') !!}
                    @if(isset($model->banco))
                        {!! Form::select('banco_id', $loadFields['banco'] , $model->banco->id, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('banco_id', $loadFields['banco'] , null, array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('taxa_id', 'Taxa *') !!}
                    @if(isset($model->taxa))
                        {!! Form::select('taxa_id', $loadFields['taxa'] , $model->taxa->id, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('taxa_id', $loadFields['taxa'] , null, array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('tipo_vencimento_id', 'Tipo de Vencimento') !!}
                    @if(isset($model->tipoVencimento))
                        {!! Form::select('tipo_vencimento_id', $loadFields['tipovencimento'] , $model->tipoVencimento->id, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('tipo_vencimento_id', $loadFields['tipovencimento'] , null, array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('qtd_dias', 'Qtd. Dias') !!}
				{!! Form::text('qtd_dias', Session::getOldInput('qtd_dias')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('data_prova', 'Data da prova') !!}
				{!! Form::text('data_prova', null, array('class' => 'form-control datepicker date')) !!}
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
                <a href="{{ route('seracademico.vestibular.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
</div>