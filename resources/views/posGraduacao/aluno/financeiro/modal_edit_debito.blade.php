<div id="modal-edit-debito" class="modal fade modal-profile" tabindex="-1"
     role="dialog" aria-labelledby="modalProfile" aria-hidden="true">

    <div class="modal-dialog modal-small">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Editar Débito</h4>
            </div>

            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="taxa_id_editar">Taxa</label>
                            <select name="taxa_id_editar" class="form-control" id="taxa_id_editar">
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="valor_taxa_editar">Valor Taxa</label>
                            <input type="text" disabled="disabled" name="valor_taxa_editar" id="valor_taxa_editar" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="valor_debito_editar">Valor Débito</label>
                            <input type="text" name="valor_taxa_editar" id="valor_debito_editar" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="data_vencimento_editar">Vencimento</label>
                            <input type="text" name="data_vencimento_editar" id="data_vencimento_editar" class="form-control datepicker">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="mes_referencia_editar">Mês de referẽncia</label>
                            <input type="text" class="form-control" name="mes_referencia_editar" id="mes_referencia_editar">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="ano_referencia_editar">Ano de referẽncia</label>
                            <input type="text" class="form-control" name="ano_referencia_editar" id="ano_referencia_editar">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="conta_bancaria_id_editar">Conta Bancária</label>
                            <select class="form-control" name="conta_bancaria_id_editar" id="conta_bancaria_id_editar"></select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="forma_pagamento_id_editar">Formas de Pagamento</label>
                            <select class="form-control" name="forma_pagamento_id_editar" id="forma_pagamento_id_editar"></select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="pago_editar">Pago ?</label>
                            <select class="form-control" name="pago_editar" id="pago_editar">
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>
                        </div>
                    </div>

                    <!--
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="repetir">Repetir ?</label>
                            <select class="form-control" name="repetir" id="repetir">
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="periodo">Período</label>
                            <select class="form-control" name="periodo" id="periodo">
                                <option value="0">Mensalmente</option>
                                <option value="1">Anualmente</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="quantidade">Quantidade</label>
                            <input type="number" id="quantidade" name="quantidade">
                        </div>
                    </div>
                    -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateDebito">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->