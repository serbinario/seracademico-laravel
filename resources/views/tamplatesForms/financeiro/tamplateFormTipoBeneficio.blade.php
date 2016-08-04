<div class="row">
	<div class="col-md-12">
    {{--Linha 1--}}
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">

                    {!! Form::label('codigo', 'Código') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo') , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">

                    {!! Form::label('nome', 'Descrição') !!}
                    {!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    {{--Linha 2--}}
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    
					{!! Form::label('valido_inicio', 'Válido') !!}
					{!! Form::text('valido_inicio', Session::getOldInput('valido_inicio'), array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">

                    {!! Form::label('valido_fim', 'Até') !!}
                    {!! Form::text('valido_fim', Session::getOldInput('valido_fim'), array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    
					{!! Form::label('data_inicio', 'Inicio') !!}
					{!! Form::text('data_inicio', Session::getOldInput('data_inicio'), array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">

                    {!! Form::label('data_fim', 'Final') !!}
                    {!! Form::text('data_fim', Session::getOldInput('data_fim'), array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">

                    {!! Form::label('tipo_id', 'Tipo') !!}
                    {!! Form::select('tipo_id', $loadFields['financeiro\\tipovalor'], NULL, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('valor', 'Valor') !!}
					{!! Form::text('valor', Session::getOldInput('valor'), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">

                    {!! Form::label('incidencia_id', 'Incidência') !!}
                    {!! Form::select('incidencia_id', $loadFields['financeiro\\incidencia'], NULL, array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    
					{!! Form::label('dia_inicial_id', 'Dia Inicial') !!}
					{!! Form::select('dia_inicial_id', $loadFields['financeiro\\datavencimento'], NULL, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">

                    {!! Form::label('dia_final_id', 'Dia Final') !!}
                    {!! Form::select('dia_final_id', $loadFields['financeiro\\datavencimento'], NULL, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">

                    {!! Form::label('tipo_dia_id', 'Tipo Dia') !!}
                    {!! Form::select('tipo_dia_id', $loadFields['financeiro\\tipodia'], NULL, array('class' => 'form-control')) !!}
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
                <a href="{{ route('seracademico.financeiro.tipoBeneficio.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
</div>