<div id="modal-create-resposta" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">×</button>
                <h4 class="modal-title">Nova Resposta</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="status">Situação</label>
                            <select name="status" class="form-control" id="status">
                                <option value="">Selecione uma situação</option>
                                <option value="D">Em desenvolvimento</option>
                                <option value="C">Concluído</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" rows="5" name="descricao" id="descricao"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSavarResposta">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>