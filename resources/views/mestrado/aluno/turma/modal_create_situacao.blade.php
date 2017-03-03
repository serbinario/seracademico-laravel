<!-- Modal principal de disciplinas -->
<div id="modal-create-situacao" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar Situação</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="situacao_create_id">Situação</label>
                                <select name="situacao_create_id" class="form-control" id="situacao_create_id">
                                </select>
                            </div>
                        </div>

                        <div class="row" id="rowTurmaOrigem">
                            <div class="form-group col-md-12">
                                <label for="turma_origem_id">Turma Origem</label>
                                <select name="turma_origem_id" class="form-control" id="turma_origem_id">
                                </select>
                            </div>
                        </div>

                        <div class="row" id="rowTurmaDestino">
                            <div class="form-group col-md-12">
                                <label for="turma_destino_id">Turma Destino</label>
                                <select name="turma_destino_id" class="form-control" id="turma_destino_id">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSalvarSituacao">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->

