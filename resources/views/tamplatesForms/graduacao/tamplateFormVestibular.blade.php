<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome *') !!}
                    {!! Form::text('nome', Session::getOldInput('nome'), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
				{!! Form::label('codigo', 'Codigo *') !!}
				{!! Form::text('codigo', Session::getOldInput('codigo'), array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('semestre_id', 'Semestre *') !!}
                    @if(isset($model->banco))
                        {!! Form::select('semestre_id', $loadFields['graduacao\\semestre'] , $model->banco->id, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('semestre_id', $loadFields['graduacao\\semestre'] , null, array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>

            <div class="form-group col-md-1">
                {!! Form::label('ativar', 'Ativar') !!}
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('ativo', 0) !!}
                    {!! Form::checkbox('ativo', 1, null, array('class' => 'form-control', 'id'=>'ativo')) !!}
                    {!! Form::label('ativo', 'Ativar', false) !!}
                </div>
            </div>
		</div>

        <hr class="hr-line-dashed"/>

        {{--Linha da da Abas--}}
        <div class="row">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#prova" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">event</i> Prova</a>
                    </li>
                    <li role="presentation" >
                        <a href="#inscricoes" aria-controls="dados" data-toggle="tab"><i class="material-icons">playlist_add</i> Inscrições</a>
                    </li>
                    <li role="presentation">
                        <a href="#dadosBoleto" aria-controls="contato" role="tab" data-toggle="tab"><i class="material-icons">playlist_add_check</i> Dados Boleto</a>
                    </li>
                    <li role="presentation">
                        <a href="#dadosConfirInscricao" aria-controls="contato" role="tab" data-toggle="tab"><i class="material-icons">playlist_add_check</i> Dados Inscrição</a>
                    </li>


                    <li role="presentation">
                        <a href="#taxa" aria-controls="ensMedio" role="tab" data-toggle="tab"><i class="material-icons">event_seat</i> Taxa</a>
                    </li>



                </ul>
                <!-- End Nav tabs -->

                <!-- Tab panes -->
                <div class="tab-content">

                    {{--Aba Prova--}}
                    <div role="tabpanel" class="tab-pane active" id="prova">
                        <br/>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('data_prova', 'Data da prova') !!}
                                {!! Form::text('data_prova', null, array('class' => 'form-control datepicker date')) !!}
                            </div>
                        </div>



                    </div>
                    {{--FIM Aba Prova --}}

                    {{--Aba Inscrições--}}
                    <div role="tabpanel" class="tab-pane" id="inscricoes">
                        <br/>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    @if(isset($model->id))
                                        {!! Form::label('data_ranger', 'Data Inicial - Data Final') !!}
                                        {!! Form::text('data_ranger', "{$model->data_inicial} - {$model->data_final}" , array('class' => 'form-control ','id' => 'data_ranger', 'placeholder' => 'dd/mm/yyyy')) !!}
                                    @else
                                        {!! Form::label('data_ranger', 'Data Inicial - Data Final') !!}
                                        {!! Form::text('data_ranger', null , array('class' => 'form-control ','id' => 'data_ranger', 'placeholder' => 'dd/mm/yyyy')) !!}
                                    @endif
                                </div>
                            </div>
                            {{--<div class="col-md-2">--}}
                                {{--<div class="form-group">--}}

                                    {{--{!! Form::label('data_final', 'Data Final') !!}--}}
                                    {{--{!! Form::text('data_final', null, array('class' => 'form-control date', 'placeholder' => 'dd/mm/yyyy')) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    @if(isset($model->id) && empty($model->hora_inicial))
                                        {!! Form::label('hora_inicial', 'Hora Inicial') !!}
                                        {!! Form::text('hora_inicial', $model->hora_inicial ?? '00:00:00', array('class' => 'form-control', 'placeholder' => 'HH:mm:ss')) !!}
                                    @else
                                        {!! Form::label('hora_inicial', 'Hora Inicial') !!}
                                        {!! Form::text('hora_inicial', '00:00:00', array('class' => 'form-control', 'placeholder' => 'HH:mm:ss')) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    @if(isset($model->id) && empty($model->hora_final))
                                        {!! Form::label('hora_final', 'Hora Final') !!}
                                        {!! Form::text('hora_final', $model->hora_final ?? '23:59:59', array('class' => 'form-control', 'placeholder' => 'HH:mm:ss')) !!}
                                    @else
                                        {!! Form::label('hora_final', 'Hora Final') !!}
                                        {!! Form::text('hora_final', '23:59:59', array('class' => 'form-control', 'placeholder' => 'HH:mm:ss')) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('qtd_vagas', 'Qtd. Vagas') !!}
                                    {!! Form::text('qtd_vagas', Session::getOldInput('qtd_vagas')  , array('class' => 'form-control numberFor')) !!}
                                </div>
                            </div>

                        </div>

                    </div>
                    {{--FIM Aba Inscrições --}}

                    {{--Aba Dados do Boleto--}}
                    <div role="tabpanel" class="tab-pane" id="dadosBoleto">
                        <br/>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('instrucoes_boleto', 'Instruções de boleto') !!}
                                {!! Form::text('instrucoes_boleto', Session::getOldInput('instrucoes_boleto')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>

                    </div>
                    {{--FIM Aba Dados do Boleto --}}

                    {{--Aba Dados de Confimação de Inscrição--}}
                    <div role="tabpanel" class="tab-pane" id="dadosConfirInscricao">
                        <br/>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('confirmacao_inscricao', 'Confirmação de Inscrição') !!}
                                {!! Form::text('confirmacao_inscricao', Session::getOldInput('confirmacao_inscricao')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>

                    </div>
                    {{--FIM Aba Dados de Confimação de Inscrição --}}

                    {{--Aba Taxa--}}
                    <div role="tabpanel" class="tab-pane" id="taxa">
                        <br/>

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
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('qtd_dias', 'Qtd. Dias') !!}
                                {!! Form::text('qtd_dias', Session::getOldInput('qtd_dias')  , array('class' => 'form-control numberTwo')) !!}
                            </div>
                        </div>

                    </div>
                    {{--FIM Aba Taxa --}}


                </div>
                <!-- FIM Tab panes -->
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

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/vestibular/validacao/form_validation.js')  }}"></script>
    <script type="text/javascript">
        // Alerta para ativar o vestibular
        $(document).on('click', '#ativo', function () {
            if ($(this).is(':checked')) {
                swal("Marcando esse Vestibular como ativo, estará automaticamente desativando o atual ativo.", "Click no botão abaixo!", "warning");
            }
        });
    </script>
@stop