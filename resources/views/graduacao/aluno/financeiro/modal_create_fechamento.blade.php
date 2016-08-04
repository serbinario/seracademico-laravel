<!-- Modal principal de disciplinas -->
<div id="modal-create-fechamento" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog" style="width: 40%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Cadastrar Fechamento</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="valor_parcela">Valor Parcela</label>
                            <input type="text" disabled="disabled" name="valor_parcela" id="valor_parcela" class="form-control">
                        </div>
                   </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="valor_pago">Valor Pago</label>
                            <input type="text" disabled="disabled" name="valor_pago" id="valor_pago" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="valor_debito_fechamento">Valor Débito</label>
                            <input type="text" disabled="disabled" name="valor_debito_fechamento" id="valor_debito_fechamento" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="data_vencimento_fechamento">Vencimento</label>
                            <input type="text" disabled="disabled" name="data_vencimento_fechamento" id="data_vencimento_fechamento" class="form-control datepicker">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="data_fechamento">Data</label>
                            <input type="text" readonly="readonly" name="data_vencimento_fechamento" value="{{ date('d/m/Y')  }}" id="data_vencimento_fechamento" class="form-control">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="valor_juros_fechamento">Juros</label>
                            <input type="text" name="valor_juros_fechamento" id="valor_juros_fechamento" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="valor_tipo_juros">Valor (Por Tipo de Juros)</label>
                            <input type="text" name="valor_tipo_juros" id="valor_tipo_juros" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="valor_multa_fechamento">Multa</label>
                            <input type="text" name="valor_multa_fechamento" id="valor_multa_fechamento" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="valor_tipo_multa">Valor (Por Tipo de Multa)</label>
                            <input type="text" name="valor_tipo_multa" id="valor_tipo_multa" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="valor_desconto_fechamento">Desconto</label>
                            <input type="text" name="valor_desconto_fechamento" id="valor_desconto_fechamento" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="valor_tipo_desconto">Valor (Por Tipo de Desconto)</label>
                            <input type="text" name="valor_tipo_desconto" id="valor_tipo_desconto" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="valor_acrescimo">Outros Acrés...</label>
                            <input type="text" name="valor_acrescimo" id="valor_acrescimo" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="valor_tipo_acrescimo">Valor (Por Tipo de Acréscimo)</label>
                            <input type="text" name="valor_tipo_acrescimo" id="valor_tipo_acrescimo" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="valor_descrecimo">Outros Desc...</label>
                            <input type="text" name="valor_descrecimo" id="valor_descrecimo" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="valor_tipo_descrecimo">Valor (Por Tipo de Descrécimo)</label>
                            <input type="text" name="valor_tipo_descrecimo" id="valor_tipo_descrecimo" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="forma_pagamento_id">Forma Pagamento</label>
                            <select type="text" name="forma_pagamento_id" id="forma_pagamento_id" class="form-control"></select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="local_pagamento_id">Local Pagamento</label>
                            <select type="text" name="local_pagamento_id" id="local_pagamento_id" class="form-control"></select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="valor_total">Valor Total</label>
                            <input type="text" readonly="readonly" name="valor_total" id="valor_total" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSaveFechamento">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelFechamento">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->