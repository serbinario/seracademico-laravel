    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-debitos-abertos-update" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
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
                            <select readonly="readonly" name="tipo_taxa_id_editar" class="form-control" id="tipo_taxa_id_editar">
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="taxa_id_editar">Taxa</label>
                            <select readonly="readonly" name="taxa_id_editar" class="form-control" id="taxa_id_editar">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        {{--<div class="form-group col-md-3">--}}
                            {{--<label for="valor_taxa_vestibulando_editar">Valor Taxa</label>--}}
                            {{--<input type="text" disabled="disabled" class="form-control" name="valor_taxa_vestibulando_editar" id="valor_taxa_vestibulando_editar">--}}
                        {{--</div>--}}

                        <div class="form-group col-md-3">
                            <label for="vencimento_editar">Vencimento</label>
                            <input type="text" class="form-control datepicker" name="vencimento_editar" id="vencimento_editar">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="valor_debito_editar">Valor débito</label>
                            <input type="text" readonly="readonly" class="form-control decimal" name="valor_debito_editar" id="valor_debito_editar">
                        </div>

                    </div>

                    {{--<div class="row">
                        <div class="form-group col-md-4">
                            <label for="mes_referencia_editar">Mês</label>
                            <input type="text" class="form-control" name="mes_referencia_editar" id="mes_referencia_editar">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="ano_referencia_editar">Ano</label>
                            <input type="text" class="form-control" name="ano_referencia_editar" id="ano_referencia_editar">
                        </div>
                    </div>--}}

                    <div>
                        <label for="observacao_editar">Pago</label>
                    </div>

                    <div class="row">
                        <label for="checkbox" class="finance-container-label"></label>
                        <div class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="data_pagamento_edit">Data Pagamento</label>
                                <input type="text" value="{{ date('d/m/Y')  }}" readonly="readonly"  class="form-control" name="data_pagamento_edit" id="data_pagamento_edit">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="forma_pagamento_id_edit">Forma de Pag.</label>
                                <select name="forma_pagamento_id_edit" class="form-control" id="forma_pagamento_id_edit">
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="local_pagamento_id_edit">Local de Pag.</label>
                                <select name="local_pagamento_id_edit" class="form-control" id="local_pagamento_id_edit">
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor_multa_edit">Multa</label>
                                <input type="text"  class="form-control decimal" name="valor_multa_edit" id="valor_multa_edit">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="valor_juros_edit">Juros</label>
                                <input type="text"  class="form-control decimal" name="valor_juros_edit" id="valor_juros_edit">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor_desconto_editar">Valor Desconto</label>
                                <input type="text" class="form-control decimal" name="valor_desconto_editar" id="valor_desconto_editar">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="valor_pago_edit">Valor Pago</label>
                                <input type="text" disabled="disabled" class="form-control decimal" name="valor_pago_edit" id="valor_pago_edit">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="observacao_editar">Observação</label>
                            <textarea class="form-control" rows="3" name="observacao_editar" id="observacao_editar"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Pago</label>
                                    <input name="pago"  id="pago" type="checkbox" value="1">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnDebitosAbertosUpdate">Salvar</button>
                    <button class="btn btn-default" data-dismiss="modal" id="btnCancelarDebitosAbertos">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->