<div class="row">
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Principais
                    dados</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="dados">
                <br/>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Título') !!}
                            {!! Form::text('titulo', Session::getOldInput('titulo') , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('cdd', 'CDD') !!}
                            {!! Form::text('cdd', Session::getOldInput('cdd')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('outro_cdd', 'Outra opção de CDD') !!}
                            {!! Form::text('outro_cdd', Session::getOldInput('outro_cdd')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('tipos_acervos_id', 'Tipo do acervo') !!}
                            {!! Form::select('tipos_acervos_id', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tipoacervo']->toArray()), Session::getOldInput('tipos_acervos_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('situacao_id', 'Situação') !!}
                            {!! Form::select('situacao_id', $loadFields['biblioteca\situacao'], Session::getOldInput('situacao_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('periodicidade', 'Periodicidade') !!}
                            {!! Form::text('periodicidade', Session::getOldInput('periodicidade'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('data_vencimento', 'Data de vencimento assinatura') !!}
                            {!! Form::text('data_vencimento', Session::getOldInput('data_vencimento'), array('class' => 'form-control datepicker date data2')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('exemplar_ref', 1) !!}
                            {!! Form::hidden('tipo_periodico', 2) !!}
                            {{--{!! Form::checkbox('exemplar_ref', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('exemplar_ref', 'Exemplar de referẽncia (Apenas consulta)', false) !!}--}}
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
                    <a href="{{ route('seracademico.biblioteca.indexAcervoP') }}" class="btn btn-primary btn-block"><i
                                class="fa fa-long-arrow-left"></i> Voltar</a></div>
                <div class="btn-group">
                    {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                </div>
            </div>
        </div>
    </div>
</div>