<!-- Modal principal de disciplinas -->
<div id="modal-create-beneficio" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Cadastrar Benefício</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="tipo_beneficio_id">Tipo de Benefício</label>
                            <select name="tipo_beneficio_id" class="form-control" id="tipo_beneficio_id">
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="valor_beneficio">Valor</label>
                            <input type="text"  name="valor_beneficio" id="valor_beneficio" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="data_inicio_beneficio">Inicio</label>
                            <input type="text" name="data_inicio_beneficio" id="data_inicio_beneficio" class="form-control datepicker">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="data_fim_beneficio">Fim</label>
                            <input type="text" name="data_fim_beneficio" id="data_fim_beneficio" class="form-control datepicker">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="tipo_id">Tipo</label>
                            <select name="tipo_id" class="form-control" id="tipo_id">
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="incidencia_id">Incidência</label>
                            <select name="incidencia_id" class="form-control" id="incidencia_id">
                            </select>
                        </div>
                    </div>

                    <hr>

                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-md-10">
                            <select name="taxa_id_beneficios" class="form-control" id="taxa_id_beneficios">
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button id="btnAddTaxa" class="btn btn-primary">Adicionar</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="table-responsive no-padding">
                                <table id="beneficios-taxas-grid" class="display table table-bordered" cellspacing="0" width="100%">
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
                <button class="btn btn-primary" id="btnSaveBeneficio">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelBeneficio">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->