<!-- Modal principal de disciplinas -->
<div id="modal-create-debito-aberto" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Cadastrar Débito</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="taxa_id">Taxa</label>
                            <select name="taxa_id" class="form-control" id="taxa_id">
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="data_vencimento">Vencimento</label>
                            <input type="text" name="data_vencimento" id="data_vencimento" class="form-control datepicker">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="valor_taxa">Valor Taxa</label>
                            <input type="text" disabled="disabled" name="valor_taxa" id="valor_taxa" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="valor_desconto">Desconto</label>
                            <input name="valor_desconto" id="valor_desconto" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="valor_debito">Valor Débito</label>
                            <input type="text" name="valor_taxa" id="valor_debito" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="mes_referencia">Mês referência</label>
                            <input type="text" name="mes_referencia" id="mes_referencia" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="ano_referencia">Ano referência</label>
                            <input type="text" name="ano_referencia" id="ano_referencia" class="form-control">
                        </div>
                    </div>

                    <hr>

                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-md-10">
                            <select name="beneficio_id_debito" class="form-control" id="beneficio_id_debito">
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button id="btnAddBeneficio" class="btn btn-primary">Adicionar</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="grid-debitos-beneficios" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th style="width:10%;">Benefício</th>
                                    <th style="width:10%;">Valor</th>
                                    <th style="width: 5%;">Ação</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSaveDebitoAberto">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelDebitoAberto">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->