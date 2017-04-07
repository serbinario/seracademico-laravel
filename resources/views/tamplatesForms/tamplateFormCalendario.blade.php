<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4">
                {!! Form::label('nome', 'Nome') !!}
                {!! Form::text('nome', Session::getOldInput('nome'), array('class' => 'form-control', 'placeholder' => 'Nome do calendário')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('ano', 'Ano') !!}
                {!! Form::text('ano', Session::getOldInput('ano'), array('class' => 'form-control', 'placeholder' => 'Ano do calendário')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('duracao_id', 'Duração') !!}
                {!! Form::select('duracao_id', (["" => "Selecione duração"] + $loadFields['calendarioduracao']->toArray()), Session::getOldInput('duracao_id'), array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                {!! Form::label('data_inicial', 'Data Inicial') !!}
                {!! Form::text('data_inicial', Session::getOldInput('data_inicial'), array('class' => 'form-control datepicker date', 'placeholder' => 'Data inicial')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('data_final', 'Data Inicial') !!}
                {!! Form::text('data_final', Session::getOldInput('data_final'), array('class' => 'form-control datepicker', 'placeholder' => 'Data final')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('data_resultado_final', 'Data Resultado Final') !!}
                {!! Form::text('data_resultado_final', Session::getOldInput('data_resultado_final'), array('class' => 'form-control datepicker date', 'placeholder' => 'Data de resultado final')) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                {!! Form::label('dias_letivos', 'Dias Letivos') !!}
                {!! Form::text('dias_letivos', Session::getOldInput('dias_letivos'), array('class' => 'form-control', 'readonly' => 'readonly')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('semanas_letivas', 'Semanas Letivas') !!}
                {!! Form::text('semanas_letivas', Session::getOldInput('dias_letivos'), array('class' => 'form-control', 'readonly' => 'readonly')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('status_id', 'Status') !!}
                {!! Form::select("status_id", (["" => "Selecione duração"] + $loadFields['calendariostatus']->toArray()), null, array('class'=> 'form-control')) !!}
            </div>
        </div>
        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="{{ route('seracademico.calendarioAnual.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                    </div>
                </div>
            </div>
            {{--Fim Buttons Submit e Voltar--}}
        </div>
    </div>
</div>