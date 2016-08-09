<!-- Modal principal de disciplinas -->
<div id="modal-edit-beneficio" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Editar Benefício</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="tipo_beneficio_id_editar">Tipo de Benefício</label>
                            <select name="tipo_beneficio_id_editar" class="form-control" id="tipo_beneficio_id_editar">
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="valor_beneficio_editar">Valor</label>
                            <input type="text"  name="valor_beneficio_editar" id="valor_beneficio_editar" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="data_inicio_beneficio_editar">Inicio</label>
                            <input type="text" name="data_inicio_beneficio_editar" id="data_inicio_beneficio_editar" class="form-control datepicker">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="data_fim_beneficio_editar">Fim</label>
                            <input type="text" name="data_fim_beneficio_editar" id="data_fim_beneficio_editar" class="form-control datepicker">
                        </div>
                    </div>

                    <hr>

                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-md-10">
                            <select name="taxa_id_beneficios_editar" class="form-control" id="taxa_id_beneficios_editar">
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button id="btnAddTaxaEditar" class="btn btn-primary">Adicionar</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="table-responsive no-padding">
                                <table id="beneficios-taxas-grid-editar" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th style="width: 5%;">Código</th>
                                        <th>Nome</th>
                                        <th style="width: 5%;">Acão</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateBeneficio">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelBeneficio">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->