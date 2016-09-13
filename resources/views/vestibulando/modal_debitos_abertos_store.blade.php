    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-debitos-abertos-store" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog modal-lg"  style="width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Adicionar débito</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="tipo_taxa_id">Tipo da taxa</label>
                            <select name="tipo_taxa_id" class="form-control" id="tipo_taxa_id">
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="taxa_id">Taxa</label>
                            <select name="taxa_id" class="form-control" id="taxa_id">
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="vencimento">Vencimento</label>
                            <input type="text" class="form-control datepicker" name="vencimento" id="vencimento">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="valor_debito">Valor débito</label>
                            <input type="text" readonly="readonly" class="form-control" name="valor_debito" id="valor_debito">
                        </div>
                    </div>

                    {{--<div class="row">--}}
                        {{--<div class="form-group col-md-4">--}}
                            {{--<label for="mes_referencia">Mês</label>--}}
                            {{--<input type="text" class="form-control" name="mes_referencia" id="mes_referencia">--}}
                        {{--</div>--}}

                        {{--<div class="form-group col-md-4">--}}
                            {{--<label for="ano_referencia">Ano</label>--}}
                            {{--<input type="text" class="form-control" name="ano_referencia" id="ano_referencia">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div>
                        <label>Pago</label>
                    </div>

                    <div class="row">
                        <label for="checkbox" class="finance-container-label"></label>
                        <div class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="data_pagamento">Data Pagamento</label>
                                <input type="text" value="{{ date('d/m/Y')  }}" readonly="readonly"  class="form-control" name="data_pagamento" id="data_pagamento">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="forma_pagamento_id">Forma de Pag.</label>
                                <select name="forma_pagamento_id" class="form-control" id="forma_pagamento_id">
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="local_pagamento_id">Local de Pag.</label>
                                <select name="local_pagamento_id" class="form-control" id="local_pagamento_id">
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor_multa">Multa</label>
                                <input type="text"  class="form-control decimal" name="valor_multa" id="valor_multa">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="valor_juros">Juros</label>
                                <input type="text"  class="form-control decimal" name="valor_juros" id="valor_juros">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor_desconto">Valor Desconto</label>
                                <input type="text" class="form-control decimal" name="valor_desconto" id="valor_desconto">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor_pago">Valor Pago</label>
                                <input type="text" disabled="disabled" class="form-control decimal" name="valor_pago" id="valor_pago">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="observacao">Observação</label>
                            <textarea class="form-control" rows="3" name="observacao" id="observacao"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Pago</label>
                                    <input name="pago_create"  id="pago_create" type="checkbox" value="1">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnDebitosAbertosSalvar">Salvar</button>
                    <button class="btn btn-default" data-dismiss="modal" id="btnCancelarDebitosAbertos">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->