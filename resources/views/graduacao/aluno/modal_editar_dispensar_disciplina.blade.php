<!-- Modal principal de disciplinas -->
<div id="modal-editar-dispensar-disciplina" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Dispensar Disciplina</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="disciplina_id_editar">Disciplina *</label>
                            <select name="disciplina_id_editar" class="form-control" id="disciplina_id_editar">
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="motivo_id_editar">Motivo *</label>
                            <select name="motivo_id_editar" class="form-control" id="motivo_id_editar">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="carga_horaria_editar">CH. Total</label>
                            <input type="text" class="form-control" name="carga_horaria_editar" id="carga_horaria_editar">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="qtd_credito_editar">Qtd. Crédito</label>
                            <input type="text" class="form-control" name="qtd_credito_editar" id="qtd_credito_editar">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="instituicao_id_editar">Intituição</label>
                            <select name="instituicao_id_editar" class="form-control" id="instituicao_id_editar">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="data_editar">Data</label>
                            <input type="text" class="form-control datepicker" name="data_editar" id="data_editar">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="media_editar">Média</label>
                            <input type="text" class="form-control" name="media_editar" id="media_editar">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateDispensarDisciplina">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->