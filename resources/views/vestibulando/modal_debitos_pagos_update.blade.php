    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-debitos-pagos-update" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog modal-lg"  style="width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Editar débito</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="tipo_taxa_id">Tipo da taxa</label>
                            <select readonly="readonly" name="tipo_taxa_id_pago" class="form-control" id="tipo_taxa_id_pago">
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="taxa_id_pago">Taxa</label>
                            <select readonly="readonly" name="taxa_id_pago" class="form-control" id="taxa_id_pago">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        {{--<div class="form-group col-md-3">--}}
                            {{--<label for="valor_taxa_vestibulando_pago">Valor Taxa</label>--}}
                            {{--<input type="text" disabled="disabled" class="form-control" name="valor_taxa_vestibulando_pago" id="valor_taxa_vestibulando_pago">--}}
                        {{--</div>--}}

                        <div class="form-group col-md-3">
                            <label for="vencimento_pago">Vencimento</label>
                            <input type="text" class="form-control datepicker" name="vencimento_pago" id="vencimento_pago">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="valor_debito_pago">Valor débito</label>
                            <input type="text" readonly="readonly" class="form-control decimal" name="valor_debito_pago" id="valor_debito_pago">
                        </div>

                    </div>

                    {{--<div class="row">
                        <div class="form-group col-md-4">
                            <label for="mes_referencia_pago">Mês</label>
                            <input type="text" class="form-control" name="mes_referencia_pago" id="mes_referencia_pago">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="ano_referencia_pago">Ano</label>
                            <input type="text" class="form-control" name="ano_referencia_pago" id="ano_referencia_pago">
                        </div>
                    </div>--}}

                    <div>
                        <label for="observacao_pago">Pago</label>
                    </div>

                    <div class="row">
                        <label for="checkbox" class="finance-container-label"></label>
                        <div class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="data_pagamento_pago">Data Pagamento</label>
                                <input type="text" value="{{ date('d/m/Y')  }}" readonly="readonly"  class="form-control" name="data_pagamento_pago" id="data_pagamento_pago">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="forma_pagamento_id_pago">Forma de Pag.</label>
                                <select name="forma_pagamento_id_pago" class="form-control" id="forma_pagamento_id_pago">
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="local_pagamento_id_pago">Local de Pag.</label>
                                <select name="local_pagamento_id_pago" class="form-control" id="local_pagamento_id_pago">
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor_multa_pago">Multa</label>
                                <input type="text"  class="form-control decimal" name="valor_multa_pago" id="valor_multa_pago">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="valor_juros_pago">Juros</label>
                                <input type="text"  class="form-control decimal" name="valor_juros_pago" id="valor_juros_pago">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor_desconto_pago">Valor Desconto</label>
                                <input type="text" class="form-control decimal" name="valor_desconto_pago" id="valor_desconto_pago">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor_pago_pago">Valor Pago</label>
                                <input type="text" disabled="disabled" class="form-control decimal" name="valor_pago_pago" id="valor_pago_pago">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="observacao_pago">Observação</label>
                            <textarea class="form-control" rows="3" name="observacao_pago" id="observacao_pago"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnDebitosPagosUpdate">Salvar</button>
                    <button class="btn btn-default" data-dismiss="modal" id="btnCancelarDebitosPagos">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->