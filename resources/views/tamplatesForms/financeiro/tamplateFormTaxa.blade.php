<div class="row">
	<div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome * max 60 caracteres (0-9 A-Z .-[ ])') !!}
                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('codigo', 'Código * max 6') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo')  , array('class' => 'form-control numberFive')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('valor', 'Valor *') !!}
                    {!! Form::text('valor', Session::getOldInput('valor')  , array('class' => 'form-control moneyReal')) !!}
                </div>
            </div>

            <div class="form-group col-md-2">
                {!! Form::label('tipo_taxa_id', 'Tipo da Taxa * ') !!}
                {!! Form::select('tipo_taxa_id', $loadFields['financeiro\\tipotaxa'], Session::getOldInput('tipo_taxa_id'), array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('valido_inicio', 'Valido Inicio ') !!}
                    {!! Form::text('valido_inicio', Session::getOldInput('valido_inicio')  , array('class' => 'form-control date datepicker', 'id'=>'validoInicio')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('valido_fim', 'Ate Fim ') !!}
                    {!! Form::text('valido_fim', Session::getOldInput('valido_fim')  , array('class' => 'form-control date datepicker', 'id'=>'validoFim')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('dia_vencimento', 'Dia Vencimento *') !!}
                    {!! Form::text('dia_vencimento', Session::getOldInput('dia_vencimento')  , array('class' => 'form-control numberTwo')) !!}
                </div>
            </div>

            <div class="form-group col-md-2">
                {!! Form::label('tipo_debito_id', 'Tipo Debito * ') !!}
                {!! Form::select('tipo_debito_id', $loadFields['financeiro\\tipodebito'], Session::getOldInput('tipo_debito_id'), array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#movimentacao" aria-controls="movimentacao" data-toggle="tab">Movimentação Financeira</a>
                    </li>
                    <li role="presentation">
                        <a href="#multasjuros" aria-controls="multasjuros" role="tab" data-toggle="tab">Multas / Juros</a>
                    </li>
                    <li role="presentation">
                        <a href="#exigencias" aria-controls="exigencias" role="tab" data-toggle="tab">Exigências</a>
                    </li>
                </ul>
                <!-- End Nav tabs -->

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="movimentacao">
                        <br>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('banco_id', 'Banco ') !!}
                                {!! Form::select('banco_id', $loadFields['financeiro\\banco'], Session::getOldInput('banco_id'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="multasjuros">
                        <br>
                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label('tipo_multa_id', 'Tipo Multa ') !!}
                                {!! Form::select('tipo_multa_id', $loadFields['financeiro\\tipomulta'], Session::getOldInput('tipo_multa_id'), array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('valor_multa', 'Valor Multa ') !!}
                                {!! Form::text('valor_multa', Session::getOldInput('valor_multa'), array('class' => 'form-control moneyReal')) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label('tipo_juro_id', 'Tipo Juros ') !!}
                                {!! Form::select('tipo_juro_id', $loadFields['financeiro\\tipojuro'], Session::getOldInput('tipo_juro_id'), array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('valor_juros', 'Valor Juros ') !!}
                                {!! Form::text('valor_juros', Session::getOldInput('valor_juros'), array('class' => 'form-control moneyReal')) !!}
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="exigencias">
                        <br>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('exigencia_financeiro_id', 'Financeiro') !!}
                                {!! Form::select('exigencia_financeiro_id', $loadFields['financeiro\\exigencia'], Session::getOldInput('exigencia_financeiro_id'), array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group col-md-3">
                                {!! Form::label('exigencia_biblioteca_id', 'Biblioteca') !!}
                                {!! Form::select('exigencia_biblioteca_id', $loadFields['financeiro\\exigencia'], Session::getOldInput('exigencia_biblioteca_id'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('exigencia_evento_id', 'Eventos') !!}
                                {!! Form::select('exigencia_evento_id', $loadFields['financeiro\\exigencia'], Session::getOldInput('exigencia_evento_id'), array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group col-md-3">
                                {!! Form::label('exigencia_calendario_id', 'Calendário') !!}
                                {!! Form::select('exigencia_calendario_id', $loadFields['financeiro\\exigencia'], Session::getOldInput('exigencia_calendario_id'), array('class' => 'form-control')) !!}
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
                <a href="{{ route('seracademico.financeiro.taxa.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
</div>

@section('javascript')

    <script type="text/javascript">

        var dataInicio, dataFim;

        $( "#validoInicio" ).change(function() {
            dataInicio = $('#validoInicio').val();
        });

        $( "#validoFim" ).change(function() {
            dataFim = $('#validoFim').val();

            if (dataFim < dataInicio){
                swal("Você precisa inserir uma data superior a data de início", "Click no botão ok para voltar a página", "error");
                $('#validoFim').val("");
            }

        });

    </script>

    {{--Validaçao de campos--}}
    <script type="text/javascript">
        $('#formTaxa').bootstrapValidator({
            fields: {
                nome: {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', {attribute: 'Nome'})
                        },
                        stringLength: {
                            max: 60,
                            message: Lang.get('validation.max', {attribute: 'Nome'})
                        }
                    }
                },

                codigo: {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', {attribute: 'Código'})
                        }
                    },
                    stringLength: {
                        max: 6,
                        message: Lang.get('validation.max', {attribute: 'Código'})
                    }
                },

//                valor: {
//                    validators: {
//                        notEmpty: {
//                            message: Lang.get('validation.required', {attribute: 'Valor'})
//                        },
//                        stringLength: {
//                            max: 4,
//                            message: Lang.get('validation.max', {attribute: 'Valor'})
//                        }
//                    }
//                },

                tipo_taxa_id: {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', {attribute: 'Tipo de Taxa'})
                        },
                    }
                },

                dia_vencimento: {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', {attribute: 'Dia de Vencimento'})
                        },
                    }
                },

                tipo_debito_id: {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', {attribute: 'Tipo Debito'})
                        },
                    }
                },
            }
        });
    </script>

@endsection