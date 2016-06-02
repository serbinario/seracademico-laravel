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
                        <div class="form-group col-md-8">
                            <label for="tipo_taxa_id">Tipo da taxa</label>
                            <select name="tipo_taxa_id" class="form-control" id="tipo_taxa_id">
                            </select>
                        </div>

                        <div class="form-group col-md-8">
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
                            <input type="text" class="form-control" name="valor_debito" id="valor_debito">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="mes_referencia">Mês</label>
                            <input type="text" class="form-control" name="mes_referencia" id="mes_referencia">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="ano_referencia">Ano</label>
                            <input type="text" class="form-control" name="ano_referencia" id="ano_referencia">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <label for="observacao">Observação</label>
                            <textarea class="form-control" rows="5" name="observacao" id="observacao"></textarea>
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