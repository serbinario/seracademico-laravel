<!-- Modal principal de disciplinas -->
<div id="modal-inserir-dispensar-disciplina" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
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
                        <div class="form-group col-md-6">
                            <label for="curriculo_origem_id">Currículo de origem</label>
                            <select name="curriculo_origem_id" class="form-control" id="curriculo_origem_id">
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="disciplina_origem_id">Disciplina de origem</label>
                            <select name="disciplina_origem_id" class="form-control" id="disciplina_origem_id">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="disciplina_id">Disciplina *</label>
                            <select name="disciplina" class="form-control" id="disciplina_id">
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="motivo_id">Motivo *</label>
                            <select name="motivo_id" class="form-control" id="motivo_id">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="carga_horaria">CH. Total</label>
                            <input type="text" class="form-control" name="carga_horaria" id="carga_horaria">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="qtd_credito">Qtd. Crédito</label>
                            <input type="text" class="form-control" name="qtd_credito" id="qtd_credito">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="instituicao_id">Intituição</label>
                            <select name="instituicao_id" class="form-control" id="instituicao_id">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="data">Data</label>
                            <input type="text" class="form-control datepicker" name="data" id="data">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="media">Média</label>
                            <input type="text" class="form-control" name="media" id="media">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSalvarDispensarDisciplina">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->